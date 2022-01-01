<?php 
include('../../config.php');
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


if(isset($_GET['data'])){
    $data = Painel::formatarDataEnvio($_GET['data']);
    $sql = MySql::conectar()->prepare("SELECT *  FROM `tb_cliente.pedidos` pedido INNER JOIN `tb_cliente.informacoes` cliente ON cliente.id = pedido.id_cliente WHERE modificado >= '$data 00:00:00' AND modificado <= '$data 23:59:59' AND status = 1");
    $sql->execute();
    $pedidos = $sql->fetchAll();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql =MySql::conectar()->prepare("SELECT pedido.*,cliente.nome,cliente.sobrenome,endereco.estado FROM `tb_cliente.pedidos` pedido 
    INNER JOIN `tb_cliente.informacoes` cliente ON cliente.id = pedido.id_cliente 
    LEFT JOIN `tb_cliente.endereco` endereco ON endereco.id_cliente = cliente.id
    WHERE pedido.id = ?");
    $sql->execute(array($id));
    $pedidos = $sql->fetchAll();
}
   



foreach($pedidos as $key => $pedido) {
    
        $pedido_id = $pedido['id'];
        $total = $pedido['valor_total'];
        $cliente = $pedido['id_cliente'];
       
        $envio = $pedido['tipo_frete'];
        
        $barcode = new BarCode128('Pedido: '.$pedido_id, 90);
        $img = 'data:image/png;base64,' . base64_encode($barcode->get());

        $produtos_prontos = [];
        $cliente_nome = $pedido['nome'].' '.$pedido['sobrenome'];
        $data_etiqueta = date('d/m/Y',strtotime('-2 days ', strtotime($pedido['criado'])));

        $produtos_prontaEntrega = 0;

 
            echo '<p style="page-break-before:always;max-height:15cm;margin:10px;padding:0;">';
            echo "<img src='$img'>";
            echo "<br/> Pedido: $pedido_id <br/> $cliente_nome (<strong>$data_etiqueta</strong>) <br/><br/> ";

            foreach ($produtos_prontos as $prontos) {
                echo $prontos['posicao'] . ' ' .  $prontos['name'];
                if(isset($prontos['tamanho'])) { 
                    echo '<br/>' . $prontos['tamanho'] ;
                }
                if(isset($prontos['additional_information'])) { 
                    echo '&nbsp;&nbsp;&nbsp;' . $prontos['additional_information'] ;
                }
                echo '<br/>Quantidade:' . $prontos['quantidade'] .'<br/><br/>' ;
            }
                echo "<span style='font-size:28px'>".$pedido['estado']."</span>";
            
            if($envio == 'Moto Boy'){
                echo "<span style='font-size:28px'>$envio</span>";
            }
            '</p>';
        
    
}

?>



</body>

</html>