<?php
    include('../../config.php');

    /*
        Mostra informações do cliente
    */
    if(isset($_POST['id_pedido'],$_POST['pagina']) && $_POST['pagina'] == 'usuario'){
            $id = $_POST['id_pedido'];
                $sql = MySql::conectar()->prepare("SELECT pedido.id_cliente,cliente.nome,cliente.sobrenome,cliente.cpf,endereco.* FROM `tb_cliente.pedidos` pedido
                 INNER JOIN `tb_cliente.informacoes` cliente ON cliente.id = pedido.id_cliente
                 LEFT JOIN `tb_cliente.endereco` endereco ON endereco.id_cliente = pedido.id_cliente
                 WHERE pedido.id = ?");
                $sql->execute(array($id));
        
        while($cliente = $sql->fetch()){
            ?>
            <div class="detalhe_pedido">
                <div class="cliente_pedido">
                    <p class="cliente_nome"><b>Cliente:</b> <?php echo $cliente['nome'].' '.$cliente['sobrenome']; ?></p>
                </div><!-- cliente_pedido -->
                <div class="cliente_pedido">
                    <p class="cliente_cep"><b>Cep:</b> <?php echo $cliente['cep']; ?></p>
                    <p class="cliente_estado"><b>Estado:</b> <?php echo $cliente['estado']; ?></p>
                    <p class="cliente_cidade"><b>Cidade:</b> <?php echo $cliente['cidade']; ?></p>
                    <p class="cliente_endereco"><b> Bairro: </b> <?php echo  $cliente['bairro'];?><b> Rua: </b><?php echo $cliente['rua'];?><b> Complemento: </b><?php echo $cliente['complemento'];?><b> Nº: </b><?php echo $cliente['numero']; ?></p>
                </div><!-- cliente_pedido -->
            </div><!-- detalhe_pedido -->
            <?php
        }
    }

    /*
        Mostra produtos do cliente
    */
    if(isset($_POST['id_pedido'],$_POST['pagina']) && $_POST['pagina'] == 'produto'){
        $id = $_POST['id_pedido'];
        $sql = MySql::conectar()->prepare("SELECT pedido.id idPedido,produto.id_pedido,produto.qtd,estoque.*,estoque.id idProduto,imagem.imagem,imagem.produto_id FROM `tb_cliente.pedidos` pedido
        INNER JOIN `tb_cliente.produto_pedido` produto ON produto.id_pedido = pedido.id
        LEFT JOIN `tb_admin.estoque` estoque ON estoque.id = produto.id_produto
        LEFT JOIN `tb_admin.estoque_imagens` imagem ON imagem.produto_id = estoque.id
        WHERE pedido.id = ?       
        GROUP BY imagem.produto_id ");
       $sql->execute(array($id));
        ?>
        <div class="lista">
            <div class="conteiner_painel">
                <div class="painel_lista">
                    <div class="titulo_painel">
                            <div class="coluna_info_painel">Verificado</div><!--coluna_info_painel-->
                            <div class="coluna_info_painel">Produto</div><!--coluna_info_painel-->
                            <div class="coluna_info_painel">Quantidade</div><!--coluna_info_painel-->
                            <div class="coluna_info_painel">Local</div><!--coluna_info_painel-->
                    </div><!--Titulo_pedido-->
        <?php
        while($produto = $sql->fetch()){ ?>
            <div class="info_painel">
                <div class="coluna_info_painel"><input class="check_produto" type="checkbox" pedido_id="<?php echo $produto['idPedido']; ?>" produto_id="<?php echo $produto['idProduto']; ?>"></div><!--coluna_info_painel-->
                <div class="coluna_info_painel">
                    <img width="40" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN;?>produtos/<?php echo $produto['imagem']; ?>" alt="">
                    <?php echo $produto['nome']; ?>
                </div><!--coluna_info_painel-->
                <div class="coluna_info_painel"> <?php echo $produto['qtd']; ?></div><!--coluna_info_painel-->
                <div class="coluna_info_painel"> <?php echo $produto['codigo']; ?></div><!--coluna_info_painel-->
            </div><!--Info_painel-->
        <?php } ?>
                </div><!--Painel_lista-->
            </div><!--conteiner_painel-->
        </div><!--Lista-->
        <script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/pedidos.js"></script>
        <?php
    }
    /*
        Produto conferido e colocado na cesta do cliente
    */
    if(isset($_POST['produto_id'],$_POST['pedido_id'])){
        $produto_id = $_POST['produto_id'];
        $pedidos_id = $_POST['pedido_id'];
        Painel::alert('sucesso', 'Produto com ID: '.$produto_id.' separado e com pedido com ID: '.$pedidos_id);
    }
    /*
        Mostra os pedidos por data
    */

    if(isset($_POST['data_dia']) || isset($_POST['tipo'])){
        //$data = date('Y-m-d H:i:s', strtotime('-2 days', strtotime($_POST['data_dia'])));
        $data = Painel::formatarDataUS($_POST['data_dia']);
        $status_data = Painel::formatarData($_POST['data_dia']);
        $status = '';
        if(isset($_POST['conferido'])){
            $status = $_POST['conferido'];
        }
        
        if(isset($_POST['embalado'])){
            $status = $_POST['embalado'];
        }
       
      
       if(isset($_POST['tipo'])){
        $tipo = $_POST['tipo'];
       }else{
           $tipo = 'pendente_'.$status_data;
       }
       
        switch ($tipo) {
            case 'aprovado_'.$status_data:
                $status_pago = 1;
                break;
            case 'pendente_'.$status_data:
                $status_pago = 0;
                break;
            case 'canselado_'.$status_data:
                $status_pago = 2;
                break;
        }
        $pedidos = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.pedidos` WHERE criado >= '$data 00:00:00' AND criado <= '$data 23:59:59' AND status = $status_pago ORDER BY (criado) DESC");
        $pedidos->execute();
        $pedidos = $pedidos->fetchAll();
        foreach ($pedidos as $key => $value) {

           
        ?>
            <div class="info_pedido_cliente">
                        <div class="coluna_info_pedido"><?php echo $value['id'];?></div><!--Coluna_info_pedido-->
                        <div class="coluna_info_pedido">
                        <?php
                         $tipo = $value['status'];
                                                      
                            switch ($tipo) {
                                case 0:
                                    echo '<span class="pendente">Pendente</span> ';
                                    
                                    break;
                                case 1:
                                    echo '<span class="aprovado">Aprovado</span> ';
                                    break;
                                case 2:
                                    echo '<span class="cancelado">Cancelado</span> ';
                                    break;
                               
                                }
                            
                            ?>
                        </div><!--Coluna_info_pedido-->
                        <div class="coluna_info_pedido">
                        <?php echo $value['tipo_frete'] ?>
                        </div><!--Coluna_info_pedido-->
                        <div class="coluna_info_pedido"><?php echo Painel::formatarDataHora($value['criado']);?></div><!--Coluna_info_pedido-->
                        <div class="coluna_info_pedido">
                            <!--<a class="conferido_status" conferido_id="<?php echo $value['id'] ?>" href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>" ><img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/troca.png" alt="" srcset=""></a>-->
                            <img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/olho.png" alt=""  class="obs_pedido_cliente abrirmodal" abrirmodal="observacao" id_obs="<?php echo $value['id'] ?>">
                            <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>impressao/codigo_produto.php?id=<?php echo $value['id'];?>" target="_blank"><img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/codigo.png" alt="" srcset=""></a>
                            <img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/usuario.png" alt="" class="detalhes_cliente abrirmodal"  abrirmodal="cliente" id_pedido="<?php echo $value['id']?>">
                            <img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/produtos.png" alt="" class="detalhes_cliente abrirmodal"  abrirmodal="produtos" id_pedido="<?php echo $value['id']?>">

                        </div><!--Coluna_info_pedido-->
                    </div><!--Info_pedido_cliente-->  


        <?php }  ?>
        <script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/cliente.js"></script>
        <script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/modal.js"></script>
        <?php  }

    /*
        Mostra tipos de Status
    */
    
    if(isset($_POST['data'])){
        $dia = $_POST['data'];
       
        $tipo = MySql::conectar()->prepare("SELECT criado,status,COUNT(status) qtd FROM `tb_cliente.pedidos` WHERE criado >= '$dia 00:00:00' AND criado <= '$dia 23:59:59' GROUP BY status ORDER BY (criado) DESC");
        $tipo->execute();
        $mostrar = ['Pendente' => 0, 'Aprovado' => 0,'Canselado' => 0];
            $quantidade = $mostrar;
        while ($pedidos = $tipo->fetch()) {
            $status = $pedidos['status'];
            
            /*if($status == 0){
                $mostrar['Pendente'] = $pedidos['qtd'];
                $quantidade['Pendente'] = $pedidos['qtd'];
            }
            if($status == 1){
                $mostrar['Aprovado'] = $pedidos['qtd'];
                $quantidade['Aprovado'] = $pedidos['qtd'];
            }
            if($status == 2){
                $mostrar['Canselado'] = $pedidos['qtd'];
                $quantidade['Canselado'] = $pedidos['qtd'];
            }*/
            switch ($status) {
                case 0:
                   $mostrar['Pendente'] = $pedidos['qtd'];
                   $quantidade['Pendente'] = $pedidos['qtd'];
                break;
                case 1:
                    $mostrar['Aprovado'] = $pedidos['qtd'];
                    $quantidade['Aprovado'] = $pedidos['qtd'];
                break;
                case 2:
                    $mostrar['Canselado'] = $pedidos['qtd'];
                    $quantidade['Canselado'] = $pedidos['qtd'];
                break;  
            }
        }
            echo json_encode([$mostrar,$quantidade]); 
    }


?>