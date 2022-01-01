
<?php
  $url = explode('/',$_GET['url']);
  if(!isset($url[2]))
  {
  $categoria = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categoria` WHERE slug = ?");
  $categoria->execute(array(@$url[1]));
  $categoria = $categoria->fetch();
?>
<div class="page-produto">
  <div class="page-container">
    <div class="pesquisa-filter">
      <form id="filter-form-oferta"  method="post" action="<?php echo INCLUDE_PATH; ?>ajax/busca_promocao.php">
        <div class="form-group">
          <h2><i class="fas fa-filter"></i> Filter</h2>
        </div>
          
        <div class="form-group">
          <label>Preço mínimo</label>
          <input type="text" name="promocao_min" class="form-control mascara" placeholder="Digite o preço mínimo">
        </div>
        <div class="form-group">
          <label>Preço máximo</label>
          <input type="text" name="promocao_max" class="form-control mascara" placeholder="Digite o preço máximo">
        </div>
      </form>

    </div>
    <div class="lista-items" id="oferta">
      <div class="container">


        <?php 
        $query = "";
          if(isset($_POST['busca_produto']) && $_POST['busca_produto'] == 'Buscar!'){
            $nome = $_POST['busca'];
            $query = "WHERE (nome LIKE '%$nome%')";

          }
          if($query == ''){
            $query2 = "";
          }else{
            $query2 = "";
          }
          $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` $query ORDER BY id ASC");
          $sql->execute();
          $items = $sql->fetchAll();
          if($query != ''){
              echo '<div style="width:100%" ><p>Foram encontrado(s):<b>'.count($items).'</b></p></div>';
            }
          foreach ($items as $key => $value) {
            if($value['promocao'] > 0){
          $sql = MySql::conectar()->prepare("SELECT `slug` FROM `tb_admin.categoria` WHERE id = ?");
          $sql->execute(array($value['categoria_id']));
          $categoriaNome = $sql->fetch()['slug'];
          $imagem = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id]");
          $imagem->execute();
          $imagem = $imagem->fetch()['imagem'];
            
        ?>
          
        <div class="produto-single-box">
          <a class="detalhe" href="<?php echo INCLUDE_PATH; ?>produtos/<?php echo $categoriaNome; ?>/<?php echo $value['slug'];?>/<?php echo $value['id'];?>">
            <div class="time-produto">NOVO</div>
          <img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>uploads/<?php echo $imagem; ?>">
          <p><?php echo ucfirst($value['nome']); ?><br>
            <?php if($value['promocao'] != 0){ ?>
              <p><strike>Preço: R$<?php echo Painel::convertMoney($value['preco']); ?></strike><br> 
              Promoção: R$ <?php echo Painel::convertMoney($value['promocao']); ?></p>
          <?php }else{ ?><br>
            <p>Preço: R$ <?php echo Painel::convertMoney($value['preco']); ?></p>
            <?php } ?>
          </a>
        </div><!--Produto-single-box-->
      <?php } } ?>

      <div class="clear"></div>
      </div><!--Container-->
    </div><!--Lista de items-->
  </div><!-- Pages-container -->
</div><!-- Page produto -->
<br><br><br>
<?php }else{
  include('detalhe_do_produto.php');
} ?>
