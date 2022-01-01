<?php 
include('../config.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressao</title>
    <style type="text/css" media="print">
    @page {
        size: auto;   /* auto is the initial value */
        margin: 0;  /* this affects the margin in the printer settings */
    }
</style>

</head>
<body>
<?php

if(isset($_GET['tipo']) && $_GET['tipo'] == 'ml'){
   exit;
};

if(!isset($_GET['list']) && !isset($_GET['data']) && !isset($_GET['id'])){
    exit("ERRO: parametros não enviados");
}

if(isset($_GET['list']) && !empty($_GET['list'])){
    $ids = $_GET['list'];
    $sql ="SELECT id, nome, payment_form, payment_date, estado, total, shipment FROM pedidos 
    WHERE id IN ($ids)
    AND status IN('APROVADO', 'A ENVIAR YAPAY', 'A ENVIAR MERCADO PAGO' )
    ORDER BY payment_date asc, id asc";
}



if(isset($_GET['data'])){
    $data = Painel::formatarDataEnvio($_GET['data']);
    $sql = MySql::conectar()->prepare("SELECT *  FROM pedidos 
    WHERE payment_date = ?");
    $sql->execute(array($data));
    $pedidos = $sql->fetchAll();
}


$res_brindes = MySql::conectar()->prepare("SELECT * FROM configuracoes WHERE tipo like '%brinde%'");
$res_brindes->execute();
$brindes = $res_brindes->fetchAll();

foreach($pedidos as $key => $pedido) {
    
        $pedido_id = $pedido['id'];
        $total = $pedido['total'];
        $cliente = $pedido['nome'];
        $estado = $pedido['estado'];
        $envio = $pedido['shipment'];
        
        $barcode = new BarCode128($pedido_id, 110);
        
        $img = 'data:image/png;base64,' . base64_encode($barcode->get());


        $brindeTxt = '' ;
        foreach ($brindes as $key => $brinde) {
            if($brinde['id_final'] != null && $brinde['id_final'] != 0 ){ $id_final = $brinde['id_final']; } else { $id_final = 999999999999999999; }
            if(strpos($brinde['tipo'], 'boleto') !== false){
                if(strpos($pedido['payment_form'], 'Boleto') !== false && $pedido_id >= $brinde['id_inicial'] && $brinde['ativo'] == 1 && $total >= $brinde['valor'] && $pedido_id <= $id_final){
                    $brindeTxt .= $brinde['conteudo'].'<br>';
                }
            } else {
                if($pedido_id >= $brinde['id_inicial'] && $brinde['ativo'] == 1 && $total >= $brinde['valor'] && $pedido_id <= $id_final){
                    $brindeTxt .= $brinde['conteudo'].'<br>';
                }
            }   
        }

        $produtos_prontos = [];

        $data_etiqueta = date('d/m/Y',strtotime('-2 days ', strtotime($pedido['payment_date'])));


        $sql = MySql::conectar()->prepare("SELECT DISTINCT ps.name, psm.feito, psm.recortado, ps.quantity, pr.pronta_entrega, ep.posicao , additional_information
            FROM product_sold ps
            INNER JOIN product pr ON pr.id = ps.product_id
            LEFT JOIN product_sold_made psm ON psm.product_sold_id = ps.id 
            LEFT JOIN estoque_produtos ep ON ep.produto_id = ps.product_id
            WHERE ps.order_id = ?");
        $sql->execute(array($pedido_id));
        $res = $sql->fetchAll();
        $total_produtos = $sql->rowCount();

        $produto_feito = 0;

        $produtos_prontaEntrega = 0;

        while ($produto = $res) {

            $nome = strip_tags($produto['name']);
            $produto['additional_information'] = strip_tags($produto['additional_information']);
            $pronta_entrega = $produto['pronta_entrega'];
            $produto['name'] = str_replace('Papel de Parede ', '', $nome);

            if(strpos($nome, 'Tamanho') !== false){
                $produto['name'] = str_replace('Papel de Parede', '', substr($nome, 0, strpos($nome, 'Tamanho')));
                $produto['tamanho'] = substr($nome, strpos($nome, 'Tamanho'), strlen($nome));

            }


            if(strpos($nome, "BRINDE") === 0 || $pronta_entrega == 1 || isset($_GET['id']) ){
                $produto_feito += 1;
                $produtos_prontos[] = $produto; 
            
            }else if($produto['feito'] == 1){
                if((strpos($nome, 'Adesivo') !== false || strpos($nome, 'Azulejo') !== false || strpos($nome, 'Faixa') !== false || strpos($nome, 'Geladeira') !== false) && strpos($nome, 'Papel') === false){

                    if($produto['recortado'] == 1){
                        $produto_feito += 1;
                        $produtos_prontos[] = $produto; 
                    }
                } else {
                    $produto_feito += 1;
                    $produtos_prontos[] = $produto; 
                }
            }
        }



        if($produto_feito == $total_produtos){
            echo '<p style="page-break-before:always;max-height:15cm;margin:10px;padding:0;">';
            echo "<img src='$img'>";
            echo "<br/> $pedido_id <br/> $cliente (<strong>$data_etiqueta</strong>) <br/><br/> ";

            foreach ($produtos_prontos as $prontos) {
                echo $prontos['posicao'] . ' ' .  $prontos['name'];
                if(isset($prontos['tamanho'])) { 
                    echo '<br/>' . $prontos['tamanho'] ;
                }
                if(isset($prontos['additional_information'])) { 
                    echo '&nbsp;&nbsp;&nbsp;' . $prontos['additional_information'] ;
                }
                echo '<br/>Quantidade:' . $prontos['quantity'] .'<br/><br/>' ;
            }
            echo $brindeTxt;
            if(in_array($estado, ['SP', 'RJ'])){
                echo "<span style='font-size:28px'>$estado</span>";
            }
            if($envio == 'Moto Boy'){
                echo "<span style='font-size:28px'>$envio</span>";
            }
            '</p>';
        }
    
}

?>



</body>

</html>