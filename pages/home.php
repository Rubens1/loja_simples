<div class="owl-carousel owl-theme">
   
<div class="item"><img class="carousel-img" src="<?php echo INCLUDE_PATH; ?>img/2.jpg"></div>
<div class="item"><img class="carousel-img" src="<?php echo INCLUDE_PATH; ?>img/1.png"></div>
<div class="item"><img class="carousel-img" src="<?php echo INCLUDE_PATH; ?>img/banne.png"></div>


</div>	

<div class="container_servicos">
  <div class="servicos">
    <div class="servico_detalhe">
      <i class="fas fa-truck-moving"></i>
        <div class="servico_info">
          <div class="servico_titulo">ENTREGA RÁPIDA</div><!---servico_titulo--->
          <div class="p_servico">Produtos a Pronta Entrega</div><!---p_servico--->
        </div><!---servico_info--->
    </div><!---servico_titulo--->
    <div class="servico_detalhe">
      <i class="far fa-check-square"></i>
       <div class="servico_info">
          <div class="servico_titulo">LOJA 100% SEGURA</div><!---servico_titulo--->
          <div  class="p_servico">Compre com tranquilidade</div><!---p_servico--->
        </div><!---servico_info--->
    </div><!---servico_titulo--->
    <div class="servico_detalhe">
      <i class="far fa-gem"></i>
        <div class="servico_info">
          <div class="servico_titulo">PRODUTOS DIFERENTES</div><!---servico_titulo--->
          <div class="p_servico">Sempre estamos colocando produtos novos </div><!---p_servico--->
        </div><!---servico_info--->
    </div><!---servico_detalhe--->
  </div><!---servicos--->
</div><!---container_servicos--->
<div class="produtos">
  <div class="produtos-lista">
    <!--<div class="destaque">
      <div class="icon">
      <i class="far fa-star"></i>
      </div>
      <div class="info-titulo">
      Produtos em Destaque
      </div>
    </div>-->
    <div class="produtos-info">
    <?php 
    $sql = MySql::conectar()->prepare("SELECT estoque.*,categoria.slug categoriaurl FROM `tb_admin.estoque` estoque INNER JOIN `tb_admin.categorias` categoria ON categoria.id = estoque.id_categoria");
    $sql->execute();
    $produtos = $sql->fetchAll();
    foreach($produtos as $key => $value){
      $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
				$imagemSingle->execute();
				$imagemSingle = $imagemSingle->fetch()['imagem'];
        @$pocentagem = intval(100 - (100 / $value['preco'] * $value['preco_venda']));
    ?>
      <div class="produto">
        <a href="<?php echo INCLUDE_PATH; ?>produto/<?php echo $value['categoriaurl']; ?>/<?php echo $value['slug'];?>" class="link-produto">
        <?php if($value['preco'] > $value['preco_venda']){ ?> 
        <div class="desconto-porcentagem">
          <span>-<?php echo $pocentagem; ?>%</span>
        </div>
        <?php } ?>
        <div class="img-produto-pedido">
              <img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>produtos/<?php echo $imagemSingle; ?>" alt="">
          </div><!--Img-produto-pedido -->
          <div class="produto-nome">
              <?php echo $value['nome']; ?>
        </div><!--Produto-nome -->
        
        <div class="preco">
        <?php if($value['preco'] > $value['preco_venda']){ ?> 
          <div class="desconto">De R$ <?php echo $value['preco']; ?> Por</div> 
        <?php } ?>
        <div class="preco-atual"><b>R$ <?php echo $value['preco_venda']; ?></b></div>
        </div>
        
        </a>
        <div class="button-azul">
        <form action="<?php $value['id']; ?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="quantidade" value="1">
            <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
						<input type="hidden" name="acao" value="add">
            <?php if($value['quantidade'] > 1){ ?>
            <button name="comprar">Adicionar ao carrinho</button>
            <?php }else{ echo '<h2>Indisponivel</h2>'; } ?>
        </form>
        </div><!---Button-fazer--->
      </div><!--Produto -->
<?php } ?>
    </div><!--Produtos-info -->
  </div><!--Produtos-list -->
</div><!--Produtos -->


</section><!--Top Sale-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
    $('.owl-carousel').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    autoplay:true,
    autoplayTimeout:10000,
    autoplayHoverPause:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
  
  </script>