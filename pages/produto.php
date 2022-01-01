<?php
  $url = explode('/',$_GET['url']);
  if(!isset($url[2]))
  {
  

  
?>
<div class="produtos">
  <div class="produtos-lista">
    <div class="destaque">
     
     
    </div>
    <div class="produtos-info">

    <?php 
          $query = "";
          if(isset($_POST['busca']) && $_POST['busca'] == 'Buscar!'){
            $nome = $_POST['pesquisa'];
            $query = "WHERE (nome LIKE '%$nome%')";

          }
          
          $sql = MySql::conectar()->prepare("SELECT estoque.*,categoria.slug pagina FROM `tb_admin.estoque` estoque INNER JOIN `tb_admin.categorias` categoria ON categoria.id = estoque.id_categoria $query");
          $sql->execute();
          $items = $sql->fetchAll();
          
          foreach ($items as $key => $value) {
           
          $imagem = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id]");
          $imagem->execute();
          $imagem = $imagem->fetch()['imagem'];
          $pocentagem = intval(100 - (100 / $value['preco'] * $value['preco_venda']));
        ?>
      <div class="produto">
        <a href="<?php echo INCLUDE_PATH; ?>produto/<?php echo $value['pagina']; ?>/<?php echo $value['slug'];?>" class="link-produto">
        <div class="desconto-porcentagem">
          <span>-<?php echo $pocentagem; ?>%</span>
        </div>
        <div class="img-produto-pedido">
              <img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>produtos/<?php echo $imagem; ?>" alt="">
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
            <button name="comprar">Adicionar ao carrinho</button>
        </form>
        </div><!---Button-fazer--->
      </div><!--Produto -->
      <?php  } ?>
    </div><!--Produtos-info -->
  </div><!--Produtos-list -->
</div><!--Produtos -->
<?php }else{
  include('detalhe_do_produto.php');
} ?>
