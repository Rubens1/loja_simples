<?php 

include('config.php');

 
include('pages/includes/header.php');

		if(file_exists('pages/'.$url.'.php')){
			include('pages/'.$url.'.php');
		}else{
			//Podemos fazer o que quiser, pois a página não existe.
			
			if($url != 'produto'){
				$urlPar = explode('/',$url)[0];
				switch ($urlPar) {
					
					case 'produto':
						include('pages/produto.php');
						break;
					case 'categoria':
						include('pages/categoria.php');
						break;
					default:
						include('pages/404.php');
						break;
				}
				
			}else{
				include('pages/home.php');
			}
		}
 include('pages/includes/footer.php'); ?>