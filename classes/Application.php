<?php
	
	class Application
	{
		
		public function executar(){
			$url = isset($_GET['url']) ? explode('/',$_GET['url'])[0] : 'Home';

			$url = ucfirst($url);
			$url.="controller";
			if(file_exists('classes/controller/'.$url.'.php')){
				$className = 'controller\\'.$url;
				$controler = new $className;
				$controler->executar();
			}else{
				header('Location: '.INCLUDE_PATH.'erro/404.php');
				die();
			}
		}
	}
	
?>