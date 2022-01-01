<?php

	session_start();
	date_default_timezone_set('America/Sao_Paulo');
	require('composer/vendor/autoload.php');
	$autoload = function($class){
		if($class == 'Email'){
			require_once('classes/phpmailer/PHPMailerAutoLoad.php');
		}else{
			include('classes/'.$class.'.php');
		}
	};

	spl_autoload_register($autoload);




	define('INCLUDE_PATH','http://localhost/loja/');
	define('INCLUDE_PATH_PAINEL_CLIENTE',INCLUDE_PATH.'painel_cliente/');
	define('INCLUDE_PATH_PAINEL_ADMIN',INCLUDE_PATH.'painel_admin/');

	

	define('BASE_DIR_PAINEL_REVENDEDOR',__DIR__.'/painel');
	define('BASE_DIR_PAINEL_CLIENTE',__DIR__.'/cliente');
	define('BASE_DIR_PAINEL_ADMIN',__DIR__.'/painel_admin');

	//Conectar com banco de dados!
	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','db_loja');

	//Constantes para o painel de controle
	define('NOME_EMPRESA','Loja Exemplo');

	//Funções do painel
	function pegaCargo($indice){
		return Painel::$cargos[$indice];
	}

		//Verificação de permições do usuario ao visualizar item 
		function verificaPermissaoADM($permissao){
			if($_SESSION['cargo'] == $permissao){
				return;
			}else{
				echo 'style="display:none;"';
			}
		}
	
		//Marcador de item do menu
		function selecionadoMenuADM($par){
			$url = explode('/',@$_GET['url'])[0];
			if($url == $par){
				echo 'class="menu-active" style="color:#fff;"';
			}
		}
	
		//Verificação de permições do usuario ao visualizar item do menu
		function verificaPermissaoMenuADM($permissao){
			if($_SESSION['cargo'] == $permissao || $_SESSION['cargo'] == 4){
				return;
			}else{
				echo 'style="display:none;"';
			}
		}
	
		//Verificação de permições do usuario ao entrar em pagina
		function verificaPermissaoPaginaADM($permissao){
			if($_SESSION['cargo'] >= $permissao){
				return;
			}else{
				include('painel_admin/pages/permissao_negada.php');
				die();
			}
		}
	
		//Registro de Ação do usuário no sistema
		function logs($usuario,$data,$hora,$url,$acao){	
			$log = MySql::conectar()->prepare("INSERT INTO `controle_logs` VALUES (null,?,?,?,?,?)");	
			$log->execute(array($usuario,$data,$hora,$url,$acao));
		}
		
?>