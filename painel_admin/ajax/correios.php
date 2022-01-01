<?php 
include('../../config.php');

    /*
        Rastrear o pedido
    */
    if(isset($_POST['rastreio'])){
        $obj = $_POST['rastreio'];
        $post = array('Objetos' => $obj);
            // iniciar CURL
            $ch = curl_init();
            // informar URL e outras funções ao CURL
            curl_setopt($ch, CURLOPT_URL, "https://www2.correios.com.br/sistemas/rastreamento/resultado_semcontent.cfm");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($post));
            // Acessar a URL e retornar a saída
            $output = curl_exec($ch);
            // liberar
            curl_close($ch);

            // echo $output;
        
            $output = substr($output, strpos($output, '<table'), strpos($output, '</table'));
            $limpa = substr($output, strpos($output, '<script'), strpos($output, '</script'));
            $output = str_replace($limpa, '', $output);
            $limpa = substr($output, strpos($output, '<div'), strpos($output, '</div>'));
            $output = str_replace($limpa, '', $output);
            $output = strip_tags($output, '<tr><td>');
            $replace = ['<tr>', '&nbsp;', '<td>', '<td class="sroDtEvent" valign="top">'];
            $output = str_replace($replace, '', $output);
            $output = trim($output);
            $output = preg_replace('/\\n+|\\t+|\\r/', ' ', $output);
            $output = preg_replace('/\ +/', ' ', $output);
            $output = preg_replace('/- -/', '-', $output);
            $output = utf8_encode($output);
        
            // echo highlight_string($output);
        
            $array = explode('</tr>', $output);
            ?>
            <div class="lista_correios">
            <?php
            foreach ($array as $value) {
                if($value != ''){
                     //echo highlight_string($value);
               
                    $data = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', trim(substr($value, 0, 17)))));
                    $cidade = trim(substr($value, 17, strpos($value, '</td>') - 17));
                    $atualizacao = trim(str_replace('</td>','',substr($value, strpos($value, '</td>') + 5, strripos($value, '</td>') )));
                    //adicionar a div para editar todo o layout 
                    ?>
                    
                        <div class="correios">
                            <div class="data_correios">
                                <?php echo '<b>Data:</b> '.Painel::formatarData($data); ?>
                            </div><!--Data_correios-->
                            <div class="cidade_correios">
                                <?php echo  '<b>Cidade:</b> '.$cidade; ?>
                            </div><!--Cidade_correios-->
                            <div class="atualizar_correios">
                                <?php echo  '<b>Atualizado:</b> '.$atualizacao; ?>
                            </div><!--Atualizar_correios-->
                        </div><!--Correios-->
                    
                    <?php }  } ?>
            </div><!--lista_correios-->
            <?php
    }

    /*
        Caso tenha feito contato com o cliente
    */
    if(isset($_POST['contato'])){ 
        $contato_id = $_POST['contato'];
        $data = date("Y-m-d H:i:s"); 
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.pedidos_envios` WHERE pedido_id = ?");
        $sql->execute(array($contato_id));
        $contatos = $sql->fetch();
        if($contatos['contato'] == 0){
            $sql = MySql::conectar()->prepare("UPDATE `tb_admin.pedidos_envios` SET contato = ?, data_contato = ? WHERE pedido_id = $contato_id");
            $sql->execute(array(1,$data));
        ?>
          <div class="feito-contato botao_contato"><button class="contato"> Feito Contato </button></div> 
    <?php }else{
            $sql = MySql::conectar()->prepare("UPDATE `tb_admin.pedidos_envios` SET contato = ?, data_contato = ? WHERE pedido_id = $contato_id");
            $sql->execute(array(0,$data));
        ?>
        <div class="fazer-contato botao_contato"><button class="contato"> Fazer Contato </button></div> 
        <?php
    } 
} 
    
    /*
        Código de rastreio
    */
    if(isset($_POST['id_rastreio'],$_POST['codigo_rastreio'])){
        $id_rastreio = $_POST['id_rastreio'];
        $codigo_rastreio = $_POST['codigo_rastreio'];

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.pedidos` WHERE id = ?");
        $sql->execute(array($id_rastreio));

        if($sql->rowCount() > 0){
            $sql = MySql::conectar()->prepare("UPDATE `tb_cliente.pedidos` SET rastreio = ? WHERE id = $id_rastreio");
            $sql->execute(array($codigo_rastreio));
        }
    }
    ?>