<?php 
	$pedido = "";
	$sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.pedidos` WHERE id_cliente = ? ORDER BY id DESC");
	$sql->execute(array($_SESSION['id_usuario']));
	$pedidos = $sql->fetchAll();

	
					
?>
<div class="pedidos-container">
    <div class="pedidos">
        <div class="pedidos_lista">
            <div class="titulo_pedido">
                    <div class="coluna_info_pedido">Data da compra</div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido">Quantidade</div><!--Coluna_info_pedido-->

                    <div class="coluna_info_pedido">Status</div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido">Frete</div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido">Rastreio</div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido">valor Total</div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido">Detalhes</div><!--Coluna_info_pedido-->

                </div><!--Titulo_pedido-->
                <?php $contapedido = count($pedidos);
                if($sql->rowCount() == 0){ ?>
                <div class="info_pedido_cliente">Não existem pedido de nem um produto &#128557;</div>
                <?php
                }else{
                    foreach ($pedidos as $key => $value) {
                        if($value['id_cliente'] == $_SESSION['id_usuario']){
                            $pedido = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.produto_pedido` WHERE id_pedido = ?");
                            $pedido->execute(array($value['id']));
                            $pedido = $pedido->fetch();
                            $estoque = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
                            $estoque->execute(array($pedido['id_produto']));
                            $estoque = $estoque->fetch();
                            $imagemSingle = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ? ");
                            $imagemSingle->execute(array($estoque['id']));
                            $imagemSingle = $imagemSingle->fetch()['imagem'];

                ?>
                <div class="info_pedido_cliente">
                    <div class="coluna_info_pedido"><?php echo Painel::formatarData($value['criado']);?></div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido"><?php echo $pedido['id_pedido'];?></div><!--Coluna_info_pedido-->
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
                    <div class="coluna_info_pedido"> <?php echo $value['tipo_frete'] ?> </div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido"> <?php echo $value['rastreio'] ?> </div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido"><?php echo 'R$ '.Painel::convertMoney($value['valor_total']);?></div><!--Coluna_info_pedido-->
                    <div class="coluna_info_pedido">
                    <a href="<?php echo INCLUDE_PATH?>detalhes_do_pedido?id=<?php echo $value['id'];?>" target="_blank" rel="noopener noreferrer">Ver mais</a>
                    </div><!--Coluna_info_pedido-->
                </div><!--Info_pedido_cliente-->  
                <?php } } } ?>         
        </div><!--Pedidos_lista-->
	</div><!--Pedidos-->
</div><!--Pedidos-container-->
