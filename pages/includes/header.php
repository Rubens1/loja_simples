<?php
 if(isset($_SESSION['realizado']) == 1){
  unset($_SESSION['carrinho']);
}
 
    @$produtos = Carrinho::listarProdutos();

    
  if(isset($_GET['adiciona']) && $_GET['adiciona'] == 'add'){
    $id = $_GET['id'];
    Carrinho::addItemCarrinho($id);
     header('Location: '.INCLUDE_PATH.'carrinho');
    die();

  }

  if(isset($_GET['remover']) && $_GET['remover'] == 'remove'){
    $id = $_GET['id'];
     Carrinho::removerItem($id);
     header('Location: '.INCLUDE_PATH.'carrinho');
    die();
  }


  if(isset($_GET['deletar']) && $_GET['deletar'] == 'del'){
    $id = $_GET['id'];
     Carrinho::excluirProd($id);
     header('Location: '.INCLUDE_PATH.'carrinho');
    die();

  }
  if(isset($_POST['acao']) && $_POST['acao'] == 'add'){
    $id_produto = (int)$_POST['id'];
    $qtd = (int)$_POST['quantidade'];
     Carrinho::adicionarProdutos($id_produto, $qtd);
     header('Location: '.INCLUDE_PATH.'carrinho');
     die();
  }


  if(isset($_GET['consumido_loggout'])){
    Painel::consumido_loggout();
  }
    $url = isset($_GET['url']) ? $_GET['url'] : 'home';
  if(Painel::consumido_logado() == true){
      $id_consumidor = $_SESSION['id_usuario'];
      $usuario = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.informacoes` WHERE id = ?");
      $usuario->execute(array($id_consumidor));
      $usuario = $usuario->fetch();
  }
  if($url != 'produto'){
    $urlPar = explode('/',$url)[0];
  }
  if(isset($urlPar) && $urlPar == 'produto')
  {
    @$produto_url = explode('/',$url)[2];
    if(isset($produto_url)){
      $produto =  MySql::conectar()->prepare("SELECT slug,descricao,nome FROM `tb_admin.estoque` WHERE slug = ?");
      $produto->execute(array($produto_url));
      $produto = $produto->fetch();
    }else{
      $urlPar = 'produto';
    }
  }else{
    $urlPar = 'produto';
  }
  ?>

<!DOCTYPE html>
<html lang="pt">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="<?php if($urlPar == 'produto' && isset($produto_url)){echo  $produto['nome'];}else{ echo 'LOJA';} ?>">
    <meta name="description" content="<?php if($urlPar == 'produto' && isset($produto_url)){ echo strip_tags(str_replace('&nbsp;',' ',$produto['descricao']));}else{echo 'Site de Venda';} ?>">
    <meta name="author" content="Rubens de Jesus Nogueira">
    <link rel="shortcut icon" href="<?php echo INCLUDE_PATH; ?>img/ico/ico.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>font/css/all.css">

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <!--CDN do carrossel de coruja-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/global.css">
    
    <title>
      <?php
       if($url == 'home'){
          echo 'Loja'; 
        }else if(isset($produto_url)){
          echo $produto['nome'];
        }else if($urlPar == 'categoria'){
           $categoriaurl = explode('/',$url)[1]; 
           echo ucfirst($categoriaurl);
        }else if($url == 'produto'){
          echo 'Produtos';
        }else if(preg_match('/categoria/',$url)){
          $categoriaurl = explode('/',$url)[1]; 
          $categoriaurl = preg_replace('/-/',' ', $categoriaurl);
            echo  ucfirst($categoriaurl);
        }else if($url == 'adicionar_endereco'){
          echo 'Adicionar endereço'; 
        }else if($url == 'meuperfil'){
          echo 'Meu perfil'; 
        }else if($url == 'meuspedidos'){
          echo 'Meus pedidos'; 
        }else{
          echo ucfirst($url);
        } ?>
    </title>
    
  </head>
  <body>
    <base base="<?php echo INCLUDE_PATH; ?>" />
    <header>
        <div class="header">
            <div class="menu-top">
                <div class="logo"><a href="<?php echo INCLUDE_PATH; ?>"><h1>LOGO</h1></a></div><!--Logo-->
                <div class="busca">
                    <form action="<?php echo INCLUDE_PATH;?>produto" method="post">
                        <div class="busca-produto">
                            <input name="pesquisa" id="pesquisa" class="pesquisa_produto" autocomplete="off" type="text" placeholder="Busque o seu produto aqui...">
                            <button name="busca" type="submit" value="Buscar!"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    
                </div><!--Busca-->
                <div class="info">
                    <a href="<?php echo INCLUDE_PATH; ?>contato"><i class="far fa-comments"></i></a>
                    <?php 
                    if(Painel::consumido_logado() == false){ ?>
                          <a href="<?php echo INCLUDE_PATH; ?>painel_cliente"><i class="far fa-user"></i></a>
                    <?php }else{ ?>
                      <a class="user-view"><i class="far fa-user"></i><?php echo $usuario['nome']; ?></a>
                      <ul class="cliente">
                        <li>
                          <a href="<?php echo INCLUDE_PATH_PAINEL_CLIENTE; ?>meuperfil">
                             Meu Perfil
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo INCLUDE_PATH_PAINEL_CLIENTE; ?>meuspedidos">
                             Meus Pedidos
                          </a>
                        </li>
                        <li>
                          <a href="<?php echo INCLUDE_PATH; ?>?consumido_loggout"">
                             Sair
                          </a>
                        </li>
                      </ul>
                      <?php } ?>
                    <a href="<?php echo INCLUDE_PATH; ?>carrinho"><div class="compra"><i class="fab fa-opencart"></i><span class="carrinho-count"><?php echo count($produtos);?></span></div></a>
                </div><!--Info-->
               
            </div><!-- Menu-top-->
            <div class="menu-mobile">
            <div class="nav-item">
                <div class="hamburguer"></div>
            </div><!--nav-item-->
            
            <div class="logo-mobile"><a href="<?php echo INCLUDE_PATH; ?>"><img src="<?php echo INCLUDE_PATH; ?>img/logo-phone.png" alt=""></a></div><!--Logo-mobile-->
            <div class="carrinho">
            <a href="<?php echo INCLUDE_PATH; ?>carrinho"><div class="compra"><i class="fab fa-opencart"></i><span class="carrinho-count"><?php echo count($produtos);?></span></div></a>
            </div><!-- Carrinho-de-compra-->
                  
            </div><!-- Menu-mobile-->
            
            <div class="menu-segundo">
                <nav>
                    <ul>
                    <?php
             $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias`");
             $sql->execute();
             $categoria = $sql->fetchAll();
             foreach ($categoria as $key => $value) {
              $subcategoria = MySql::conectar()->prepare("SELECT * FROM `tb_admin.subcategoria` WHERE categoria_id = ?");
              $subcategoria->execute(array($value['id']));
              $subcategorias = $subcategoria->fetchAll();
              
            ?>
                        <li>
                            <a href="<?php echo INCLUDE_PATH; ?>categoria/<?php echo $value['slug']; ?>" class="menu-link">
                                
                                <div class="menu-text">
                                <?php echo $value['nome']?>
                                </div>
                            </a>
                            <?php if($subcategoria->rowCount() > 0){?>
                            <ul>
                              <div class="submenu">
                                <div class="links-submenu">
                                  <?php
                                      
                                      foreach ($subcategorias as $key => $value2) {
                                  ?>
                                    <li><a href="<?php echo INCLUDE_PATH; ?>categoria/<?php echo $value['slug'];?>/<?php echo $value2['slug']; ?>"><?php echo $value2['nome']?></a></li>
                                    <?php } ?>
                                    </div><!--Links-submenu-->
                              </div><!--Submenu-->
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                        
                    </ul>
                    
                </nav>
            </div><!-- Menu-segundo-->
        </div><!-- Header-->
        <div class="nav-list-mobile">
                <li class="nav-item-mobile">
                <form action="<?php echo INCLUDE_PATH;?>produto" method="post">
                        <div class="busca-produto">
                            <input name="pesquisa" type="text" placeholder="Busque o seu produto aqui..." autocomplete="off">
                            <input type="hidden" name="busca" value="Buscar!">
                        </div>
                    </form>
                </li>
                <?php
                foreach ($categoria as $key => $value) {
                  $subcategoria = MySql::conectar()->prepare("SELECT * FROM `tb_admin.subcategoria` WHERE categoria_id = ?");
                  $subcategoria->execute(array($value['id']));
                  $subcategorias = $subcategoria->fetchAll();
                ?>
                <li class="nav-item-mobile">
                  <a href="<?php echo INCLUDE_PATH; ?>categoria/<?php echo $value['slug']; ?>" class="nav-link-mobile"><?php echo $value['nome']; ?></a>
                </li>
                <?php } ?>
                <div class="cliente-mobile">
                <?php 
                    if(Painel::consumido_logado() == false){ ?>
                          <a href="<?php echo INCLUDE_PATH; ?>painel_cliente"><i class="far fa-user"></i>Entrar</a>
                    <?php }else{ ?>
                      <a class="user-view"  href="<?php echo INCLUDE_PATH_PAINEL_CLIENTE; ?>meuperfil"><i class="far fa-user"></i><?php echo $usuario['nome']; ?></a>
                      <a href="<?php echo INCLUDE_PATH_PAINEL_CLIENTE; ?>meuspedidos"><i class="fas fa-parachute-box"></i>Meus Pedidos</a>
                      <a href="<?php echo INCLUDE_PATH; ?>?consumido_loggout""><i class="fas fa-sign-out-alt"></i> Sair</a>
                        
                      </ul>
                      <?php } ?>
                    </div>
            </div><!--nav-list-mobile-->
    </header>