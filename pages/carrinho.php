<?php

	if(isset($_SESSION['carrino']) == ''){
		unset($_SESSION['valor_frete']);
        unset( $_SESSION['realizado']);
	}
	@$total = Carrinho::valorTotal();

?>
<div class="containe-finalizar">
    <div class="finalizar">
        <div class="carrinho-titulo">
            <div class="titulo-carrinho">
                 Meu carrinho
            </div>
            <div class="compra-mais">
                <a class="botao-continua" href="<?php echo INCLUDE_PATH;?>">Continua comprando</a>
            </div>
        </div>

            <?php 
            $contarProduto = count($produtos);
            if($contarProduto == 0){
                echo '<tr><td colspan=5>Não existem produto no carrinho &#128557;</td></tr>';
            }else{

            foreach ($produtos as $id => $produto){ 
                $produto_qtd = MySql::conectar()->prepare("SELECT quantidade FROM `tb_admin.estoque` WHERE id = ?");
                $produto_qtd->execute(array($id));
                $produto_qtd = $produto_qtd->fetch();
                $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $produto[id]");
				$imagemSingle->execute();
				$imagemSingle = $imagemSingle->fetch()['imagem'];
                $categoriaInfo = MySql::conectar()->prepare("SELECT slug FROM `tb_admin.categorias` WHERE id = ?");
				$categoriaInfo->execute(array($produto['id_categoria']));
				$categoriaNome = $categoriaInfo->fetch();
               
                ?>	
        <div class="produtos-carrinho">
            <div class="produto-carrinho">
                <div class="img-carrinho">
                    <img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>produtos/<?php echo $imagemSingle; ?>" alt="">
                    <a href="?deletar=del&id=<?php echo $produto['id'];?>"><i class="fas fa-trash-alt"></i></a>
                </div><!--Img-carrinho-->
                <div class="nome-produto">
                    <a href="<?php echo INCLUDE_PATH; ?>produto/<?php echo $categoriaNome['slug']; ?>/<?php echo $produto['slug'];?>"><?php echo $produto['nome'];?></a>
                    
                </div><!--Nome-produto-->
            </div><!--Produto-carrinho-->
            <div class="calculo-carrinho">
                <div class="quantidade-carrinho">
                        <a class="btn-carrinho" href="?remover=remove&id=<?php echo $id; ?>">- </a> 
                     <?php echo $produto['quantidade'];?> 
                    <?php if($produto['quantidade'] < $produto_qtd['quantidade']){ ?>
                        <a class="btn-carrinho" href="?adiciona=add&id=<?php echo $id; ?>"> +</a>
                    <?php }?>
                </td>
                </div><!--Quantidade-carrinho-->
                <div class="preco-carrinho">
                    R$ <?php echo Painel::convertMoney($produto['preco_venda'])?>
                </div><!--Preco-carrinho-->
            </div><!--Calculo-carrinho-->
        </div><!--Produtos-carrinho-->
        <?php } }?>
            <div class="total-carrinho">
                <div class="frete">
                    <form id="formDestino" action="" method="post">
                        <div class="frete-container">
                           <?php 
                           $endereco = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.endereco` WHERE id_cliente = ?");
                           $endereco->execute(array(@$id_consumidor));
                           $endereco_todos = $endereco->fetchAll();
                           if($endereco->rowCount() > 0){ ?>
                            <div class="endereco_container_frete">
                                <div class="todos_enderecos_frete">
                                    <?php
                                        foreach ($endereco_todos as $key => $value) {
                                            $_SESSION['id_endereco'] = $value['id'];
                                    ?>
                                        <label for="cep_<?php echo $value['id'];?>">
                                        <div class="endereco_cliente_frete">
                                            <input type="radio" name="cep" id="cep_<?php echo $value['id'];?>" value="<?php echo $value['cep'];?>"> &nbsp;<?php echo $value['cep'];?>
                                        </div><!--endereco_cliente-->
                                    </label>
                                        <?php } ?>
                                </div><!--todos_enderecos-->
                            </div><!--endereco_container_frete-->

                        <?php }else{ ?>
                            <div class="campo_frete">
                            <label><i class="fas fa-home"></i> CEP</label>
                                <input id="frete_cep" class="form-frete" type="tel" name="cep">
                            </div><!--campo_frete-->
                        <?php } ?>
                        </div><!--frete-container-->
                    </form>
                    <div class="carregando">Carregando...</div>
                    <form action="" method="post" id="formEnvio">
                        <div class="result" id="resultado">
                            <input type="hidden" id="tipofrete" name="tipofrete">
                            <div class="pac_sedex">
                                <label for="pacFrete">
                                    <div class="pac">
                                        <input type="radio" id="pacFrete" name="valorFrete">
                                            <div id="valorPac"></div>
                                    </div><!--Pac-->
                                </label>
                                <label for="sedexFrete">
                                    <div class="sedex">
                                        <input type="radio" id="sedexFrete" name="valorFrete">
                                        <div id="valorSedex"></div>
                                    </div><!--Sedex-->
                                </label>
                            </div><!--Pac_Sedex-->
                        </div><!--Result-->
                    </form>
                </div><!--Frete-->
                <div class="valor">
                    <form id="sandbox" method="post">
                        <div class="resultado-pedido">
                            <div class="resultado"><b>Resultado do Pedido</b></div>
                            <div class="subtotal"><div class="subtotal-valor">SubTotal</div><div class="valor-subtotal">R$ <?php echo Painel::convertMoney($total); ?></div></div>
                            <div class="total"><div class="total-valor">Total</div><div class="valor-total" id="valor_total"></div></div>
                            <div class="button" id="botao_compra">

                               <a href="<?php echo INCLUDE_PATH ?>verifica" class="botao-verde">Finalizar</a>
                           
                                <!--<a onclick="abrirModal()" href="#" class="botao-verde">Finalizar</a>-->
                            </div><!--Butto-->
                        </div><!--Resultado-Pedido-->
                    </form>
                </div><!--Valor-->
            </div><!--Total-carrinho-->
    </div><!--Finalizar-->
</div><!--Containe-carrinho-->
<div class="bg-modal" id="modal">
        <div class="modal">
            <span class="close" id="fecha_modal">&times;</span>
            <div id="modal_finalizar">
               
            </div>
        </div>
</div>