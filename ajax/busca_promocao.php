<?php
	include('../config.php');
	$data = array();
  $data ['sucesso'] = true;
  
    
      $promocao_min = Painel::formatarMoedaBd(str_replace('R$ ','',$_POST['promocao_min']));
      if($promocao_min === ''){
        $promocao_min = 0;
    }
      $promocao_max = Painel::formatarMoedaBd(str_replace('R$ ','',$_POST['promocao_max']));
      if($promocao_max === ''){
        $promocao_max = 0;
    }
  $sql = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE
   `tb_admin.estoque`.`promocao` >= ? AND
    `tb_admin.estoque`.`promocao` <= ? ");
  $sql->execute(array($promocao_min,$promocao_max));
  $produtos = $sql->fetchAll();
  //print_r($produtos);

  ?>

  <div class="container">
       
          
       <?php 
        foreach ($produtos as $key => $value) { 
            if($value['promocao'] > 0){
             $categoria = MySql::conectar()->prepare("SELECT `slug` FROM `tb_admin.categoria` WHERE id = ?");
             $categoria->execute(array($value['categoria_id']));
             $categoriaNome = $categoria->fetch()['slug'];
             $categoriaID = $categoria->fetch()['id'];
             $imagem = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id]");
             $imagem->execute();
             $imagem = $imagem->fetch()['imagem'];
             
            ?>
        <div class="produto-single-box">
          <a class="detalhe" href="<?php echo INCLUDE_PATH; ?>produtos/<?php echo $categoriaNome; ?>/<?php echo $value['slug'];?>">
            <div class="time-produto">NOVO</div>
          <img src="<?php echo INCLUDE_PATH_PAINEL_LOJA; ?>uploads/<?php echo $imagem; ?>">
          <p><?php echo ucfirst($value['nome']); ?><br>
              <p><strike>Preço: R$<?php echo Painel::convertMoney($value['preco']); ?></strike><br> 
              Promoção: R$ <?php echo Painel::convertMoney($value['promocao']); ?></p>
          </a>
        </div><!--Produto-single-box-->
      <?php } } ?>

      <div class="clear"></div>
      </div><!--Container-->
