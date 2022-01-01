<?php 
	include('../../config.php');
	$data = array();
  	$data ['sucesso'] = true;

  	$nome = $_POST['busca'];
  	
  	$sql = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE nome LIKE ? OR codigo  LIKE ? ");
  	$sql->execute(array("%$nome%","%$nome%"));
  	$produtos = $sql->fetchAll();


 ?>

  <div class="container">          
      <div class="owl-carousel owl-theme">
      <h2>ola</h2>
	        <?php 
	          foreach ($produtos as $key => $value) {
	            $categoriaSlug = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias` WHERE id = ?");
	            $categoriaSlug->execute(array($value['categoria_id']));
	            $categoriaNome = $categoriaSlug->fetch();
	          $imagem = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id]");
	          $imagem->execute();
	          $imagem = $imagem->fetch()['imagem'];
	          $marca =  \MySql::conectar()->prepare("SELECT * FROM `tb_admin.marca` WHERE id = ? ");
	          $marca->execute(array($value['marca_id']));
	          $marca = $marca->fetch();
	          $modelo =  \MySql::conectar()->prepare("SELECT * FROM `tb_admin.modelo` WHERE id = ? ");
	          $modelo->execute(array($value['modelo_id']));
	          $modelo = $modelo->fetch();
	            
	        ?>
	          <!-- SLIDE -->
	          <div class="item">

	              <div class="slider-box font-rale">
	               
	                <p class="time">NOVO</p>
	                <div class="img-box">
	                  <img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $imagem; ?>">
	                </div>
	                  <p class="detail"><?php
	                  if($value['nome'] == ''){
	                    echo $marca['marca'].' - '.$modelo['modelo'];
	                  }else{
	                   echo ucfirst($value['nome']); 
	                 }
	                   ?>
	                  </p>
	                  <p class="price py-2">R$ <?php echo Painel::convertMoney($value['preco']); ?></p>
	                
	            </div>
	        </div>

	    <?php } ?>
	    </div><!-- Owl Carousel-->

      <div class="clear"></div>
      </div><!--Container-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop:true,
      nav:true,
      margin:10,
      dots:false,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:3
          },
          1000:{
              items:5
          }
      }
  });
  
  </script>