<?php
  $url = explode('/',$_GET['url']);
  if($url[0] == 'categoria' && !isset($url[1]) || $url[1] == ''){
    Painel::redirect(INCLUDE_PATH);
  }
  if(!isset($url[2]))
  {
  $categoria = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias` WHERE slug = ?");
  $categoria->execute(array($url[1]));
  $categoria = $categoria->fetch();

  
?>
<div class="produtos">
  <div class="produtos-lista">
    <div class="destaque">
     
      <div class="info-titulo">
     <?php echo $categoria['nome'];?>
      </div>
    </div>
    <div class="produtos-info">

    <?php 
          $query = "";
          if(isset($_POST['busca']) && $_POST['busca'] == 'Buscar!'){
            $nome = $_POST['pesquisa'];
            $query = "WHERE (nome LIKE '%$nome%')";

          }
          if($query == ''){
            $query2 = "";
          }else{
            $query2 = "";
          }
          $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id_categoria ORDER BY id ASC");
          $sql->execute(array($categoria['id']));
          $items = $sql->fetchAll();
          
          foreach ($items as $key => $value) {
          $imagem = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ?");
          $imagem->execute(array($value['id']));
          $imagem = $imagem->fetch()['imagem'];
          @$pocentagem = intval(100 - (100 / $value['preco'] * $value['preco_venda']));
          if($categoria['id'] == $value['id_categoria']){
        ?>
      <div class="produto">
        <a href="<?php echo INCLUDE_PATH; ?>produto/<?php echo $categoria['slug']; ?>/<?php echo $value['slug'];?>" class="link-produto">
        <?php if($value['preco'] > $value['preco_venda']){ ?>
        <div class="desconto-porcentagem">
          <span>-<?php echo $pocentagem; ?>%</span>
        </div>
        <?php } ?>
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
      <?php } } ?>
    </div><!--Produtos-info -->
  </div><!--Produtos-list -->
</div><!--Produtos -->
<?php }else{
  include('detalhe_do_produto.php');
} ?>
