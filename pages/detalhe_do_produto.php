<?php 
	$url = explode('/', $_GET['url']);
	$verifica_categoria = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias` WHERE slug = ?");
	$verifica_categoria->execute(array($url[1]));
	if($verifica_categoria->rowCount() == 0){
		Painel::redirect(INCLUDE_PATH.'/');
	}
	
	
	$categoria_info = $verifica_categoria->fetch();
	$produto =  MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE slug = ? AND id_categoria = ?");
	$produto->execute(array($url[2],$categoria_info['id']));
	if($produto->rowCount() == 0){
		Painel::redirect(INCLUDE_PATH.'detalhe_do_produto');
	}

	$produto = $produto->fetch();
    $_SESSION['produto'] = $produto['nome'];
    $_SESSION['descrisao'] = $produto['descricao'];
    $parcela = $produto['preco_venda'] / 3;
 ?>
<div class="container-produto">
    <div class="info-produto">
    <?php 
        $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $produto[id]");
        $imagemSingle->execute();
        $imagemSingle = $imagemSingle->fetch()['imagem'];
	?>
        <div class="img-produto">
            <div class="img-grande" id="img">
                <img onmouseover="addZoom()" onmouseout="removeZoom()" id="imageBox" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>produtos/<?php echo $imagemSingle; ?>" alt="">
                <iframe id="videoBox" width="560" height="315" src="<?php echo $produto['video']?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div><!--img-grande-->
            <div id="img-container" class="img-zoom-result">
                    <!--Aqui vai todas as fotos em ZOOM-->
            </div><!--img-zoom-result-->
            <div class="img-pequeno">
            <?php
                $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
                $pegaImagens->execute(array($produto['id']));
                $pegaImagens = $pegaImagens->fetchAll();
                    foreach ($pegaImagens as $key => $value){
                        
            ?>
                <img class="thumbnail ativo" onclick="produtoDetalhes(this)" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>produtos/<?php echo $value['imagem']; ?>" alt="">
                <?php  } if($produto['video'] == ''){}else{ ?>
                <i id="video" onclick="produtoDetalhes(this)" class="fab fa-youtube"></i>
                <?php } ?>
            </div><!--img-pequeno-->
        </div><!--img-produto-->
        
        <div class="detalhes-produto">
           <h2><?php echo $produto['nome'];?></h2>
           <div class="avaliacao">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>
           (15)
           </div>
           <div class="preco-produto">
           <?php if($produto['preco'] > $produto['preco_venda']){ ?>
               <div class="preco-total">
                    De R$ <?php echo Painel::convertMoney($produto['preco']);?> Por
               </div><!--preco-total-->
               <?php } ?>
               <div class="preco-oferta">
                   <h2>R$ <?php echo Painel::convertMoney($produto['preco_venda']);?></h2>
                   <div class="parcelas">
                        <p>ou 3x de R$ <?php echo Painel::convertMoney($parcela);?> Sem juros</p>
                   </div><!--parcelas-->
               </div><!--preco-oferta-->
           </div><!--preco-produto-->
           
           <div class="pagamento">
           <i class="fas fa-money-check-alt"></i>
                <div class="pagamento-produto">
                    <p class="titulo-pagamento">Forma de pagamento</p>
                    <p class="texto-pagamento">
                        <div class="pagamento_modal abrirmodal" abrirmodal="pagamento">Ver mais opções de pagamento</div>
                    </p>
                </div><!--pagamento-produto-->
           </div><!--pagamento-->
           <div class="tamanhos">
               <!--<p>Tamanho: <?php echo $produto['tamanho'];?></p>-->
           </div><!--tamanhos-->
           <p>Quantidade Disponivel: <?php echo $produto['quantidade'];?></p>
           <div class="compra-agora">
                <form action="<?php $produto['id']; ?>" method="post" enctype="multipart/form-data">
                <?php if($produto['quantidade'] > 1){ ?>
                    <div class="quantidade-produto">
                        <div class="quantidade_item">
                            <div class="min_qtd" id="min_qtd">-</div>
                            <input type="tel" name="quantidade" class="numeros-produto" value="1" id="qtd_item">
                            <div class="max_qtd" id="max_qtd">+</div>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
                        <input type="hidden" id="quantidade_produto" value="<?php echo $produto['quantidade']; ?>">
						<input type="hidden" name="acao" value="add">
                        <button name="comprar" class="botao-compra"><i class="fab fa-opencart"></i> COMPRAR</button>
                    </div><!--quantidade-produto-->
                    <?php }else{ echo '<h2>Indisponivel</h2>'; } ?>
                </form>
           </div><!--compra-agora-->
        </div><!---->
    </div><!--info-produto-->
    <div class="informacoes-produto">
   <h3>Descrição do Produto</h3>
    <div class="produto-descricao">
    <p><?php echo $produto['descricao'] ?></p>
    </div><!--produto-descrica-->
    </div><!--informacoes-produto-->
    <div class="avaliacao">
        <div class="titulo-avaliacao">
            <!--<h2>Avaliações do produto</h2>-->
        </div><!--titulo-avaliacao-->
    </div><!--avaliacao-->
</div><!--container-produto-->
<div class="bg-modal" id="modal_pagamento">
    <div class="modal">
        <div class ="fecha-modal">
            <span class="close">&times;</span>
        </div>
        <div class="titulo">Formas de pagamento </div>
        <div class="forma_pagamento">
            <div class="titulos_pagamentos">
                <div class="titulo_pagamento"><img src="https://api.iconify.design/clarity/bar-code-line.svg?color=%23056789&width=20" alt=""> Boleto</div>
                <div class="titulo_pagamento"><img src="https://api.iconify.design/bi/credit-card.svg?color=%23056789&width=20" alt=""> Cartão</div>
                <div class="titulo_pagamento"><img src="https://api.iconify.design/ic/baseline-pix.svg?width=20&color=%2332bcad" alt=""> Pix</div>
            </div><!--forma_pagamento-->
            <div class="detalhe_pagamento">
                <div class="coluna_pagamento">5% de Desconto</div>
                <div class="coluna_pagamento">Em ate 6x sem juros</div>
                <div class="coluna_pagamento">5% de Desconto</div>
            </div>
        </div><!--forma_pagamento-->
    </div><!--modal-->
</div><!--bg-modal-->
