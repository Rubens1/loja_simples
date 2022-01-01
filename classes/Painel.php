<?php
	
	class Painel
	{
		
		/*
			Gargos permitidos
		*/

		public static $cargos = [
			'0' => 'Produção',
			'1' => 'Impressão',
			'2' => 'Embalagem',
			'3' => 'Atendimento',
			'4' => 'Administrador'];

		/*
			Sistema de paginas do JavaScript ADMIN
		*/

		public static function loadJS($files,$page){
			$url = explode('/',@$_GET['url'])[0];
			if($page == $url){
				foreach ($files as $key => $value) {
					echo '<script src="'.INCLUDE_PATH_PAINEL_ADMIN.'js/'.$value.'.js"></script>';
				}
			}
		}

		/*
			Sistema de paginas do JavaScript Ckeditor
		*/

		public static function loadJSCkeditor($files,$page){
			$url = explode('/',@$_GET['url'])[0];
			if($page == $url){
				foreach ($files as $key => $value) {
					echo '<script src="'.INCLUDE_PATH.'ckeditor/'.$value.'.js"></script>';
				}
			}
		}

		/*
			Sistema de paginas do JavaScript Ecommerce
		*/

		public static function loadJSEcommerce($files,$page){
			$url = explode('/',@$_GET['url'])[0];
			if($page == $url){
				foreach ($files as $key => $value) {
					echo '<script src="'.INCLUDE_PATH.'js/'.$value.'.js"></script>';
				}
			}
		}

				/*
			Sistema de paginas do JavaScript Cliente
		*/

		public static function loadJSCliente($files,$page){
			$url = explode('/',@$_GET['url'])[0];
			if($page == $url){
				foreach ($files as $key => $value) {
					echo '<script src="'.INCLUDE_PATH_PAINEL_CLIENTE.'js/'.$value.'.js"></script>';
				}
			}
		}

		/*
			Conversão de decimal do banco de dados para valores em moeda
		*/

		public static function convertMoney($valor){
			return number_format($valor, 2, ',','.');
		}
		/*
			Conversão de decimal do banco de dados para valores em em branco
		*/

		public static function convertMoney2($valor){
			return number_format($valor, 2, ',','');
		}

		/*
			Conversão para salvar o valor em decimal no banco de dados
		*/

		public static function formatarMoedaBd($valor){
			$valor = str_replace('.','',$valor);
			$valor = str_replace(',','.',$valor);
			return $valor;
		}

		/*
			Formataão de data
		*/

		public static function formatarData($tempo){
			return date('d/m/Y',strtotime($tempo));
		}

		/*
			Formatação de data para tipo banco de dados
		*/

		public static function formatarDataEnvio($tempo){
			return date('Y-m-d', strtotime('0 days',strtotime(str_replace('/', '-', $tempo))));
		}
		
		/*
			Formataão de data e horas
		*/

		public static function formatarDataHora($tempo){
			return date('d/m/Y H:i:s',strtotime($tempo));
		}
		
		/*
			Formataão de data mes e ano somente
		*/

		public static function formatarData2($tempo){
			return date('m/Y',strtotime($tempo));
		}
		
		/*
			Formatação de data para o padrão US
		*/

		public static function formatarDataUS($tempo){
			return date('Y-m-d',strtotime($tempo));
		}

				/*
			Conversão para salvar o valor em decimal e remover R$ no banco de dados
		*/
		public static function formatarMoedaBdJS($valor){
			$valor = str_replace('.','',$valor);
			$valor = str_replace(',','.',$valor);
			$valor = str_replace('R$ ','',$valor);
			return $valor;
		}

		/*
			Formatar porcentagem para salvar no banco de dados 
		*/

		public static function formatarPorcentagem($valor){
			$valor = str_replace('%','',$valor);
			return $valor;
		}

		/*
			Remoção espacos e acentos da imagem
		*/
		
        public static function formatarNomeIMG($string){
			$string = preg_replace('/(â|á|ã)/', 'a', $string);
			$string = preg_replace('/(ê|é)/', 'e', $string);
			$string = preg_replace('/(í|Í)/', 'i', $string);
			$string = preg_replace('/(ú)/', 'u', $string);
			$string = preg_replace('/(ó|ô|õ|Ô)/', 'o',$string);
			$string = preg_replace('/( )/', '_',$string);
			$string = strtolower($string);
			return $string;
            
        }

		/*
			Remover o caracter do cep
		*/
		public static function formatarCep($cep){
			$cep = preg_replace('/(-)/','',$cep);
			return $cep;
		}

    	/*
			Remoção de string em letras e caracteres para itens
		*/

		public static function generateSlug($str){
			$str = mb_strtolower($str);
			$str = preg_replace('/(â|á|ã)/', 'a', $str);
			$str = preg_replace('/(ê|é)/', 'e', $str);
			$str = preg_replace('/(í|Í)/', 'i', $str);
			$str = preg_replace('/(ú)/', 'u', $str);
			$str = preg_replace('/(ó|ô|õ|Ô)/', 'o',$str);
			$str = preg_replace('/(_|\/|!|\?|#)/', '',$str);
			$str = preg_replace('/( )/', '-',$str);
			$str = preg_replace('/ç/','c',$str);
			$str = preg_replace('/(-[-]{1,})/','-',$str);
			$str = preg_replace('/(,)/','-',$str);
			$str=strtolower($str);
			return $str;
		}
		
		
		/*
			Verificação de revendedor logado
		*/

		public static function revendedor_logado(){
			return isset($_SESSION['login']) ? true : false;
		}

		/*
			Destruir session de revendedor logado
		*/

		public static function revendedor_loggout(){
			setcookie('lembrar','true',time()-1,'/');
			session_destroy();
			header('Location: '.INCLUDE_PATH_PAINEL_REVENDEDOR);
		}

		/*
			Verificação de colaborador logado
		*/

		public static function admin_logado(){
			return isset($_SESSION['login_admin']) ? true : false;
		}

		/*
			Destruir session de colaborador logado
		*/
		public static function admin_loggout(){
			setcookie('lembrar','true',time()-1,'/');
			session_destroy();
			header('Location: '.INCLUDE_PATH_PAINEL_ADMIN);
		}

		/*
			Verificação de consumidor logado
		*/

		public static function consumido_logado(){
			return isset($_SESSION['consumido']) ? true : false;
		}

		/*
			Destruir session de consumidor logado
		*/
		public static function consumido_loggout(){
			setcookie('lembrar','true',time()-1,'/');
			session_destroy();
			header('Location: '.INCLUDE_PATH);
		}

		/*
			Carregamento de paginas do revendedor dinamico
		*/

		public static function carregarPaginaRevendedor(){
			if(isset($_GET['url'])){
				$url = explode('/',$_GET['url']);
				if(file_exists('pages/'.$url[0].'.php')){
					include('pages/'.$url[0].'.php');
				}else{
					//Página não existe!
					
				}
			}else{
				include('pages/home.php');
			}
		}
		/*
			Carregamento de paginas do colaborado dinamico
		*/
		public static function carregarPaginaADM(){
			if(isset($_GET['url'])){
				$url = explode('/',$_GET['url']);
				if(file_exists('pages/'.$url[0].'.php')){
					include('pages/'.$url[0].'.php');
				}else{
					//Página não existe!
					include('pages/404.php');
				}
			}else{
				include('pages/home.php');
			}
		}

		/*
			Carregamento de paginas do cliente dinamico
		*/
		public static function carregarPaginaCliente(){
			if(isset($_GET['url'])){
				$url = explode('/',$_GET['url']);
				if(file_exists('pages/'.$url[0].'.php')){
					include('pages/'.$url[0].'.php');
				}
			}else{
				include('pages/meuperfil.php');
			}
		}


		/*
			Lista pessoas online 
		*/
		public static function listarUsuariosOnline(){
			self::limparUsuariosOnline();
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.online`");
			$sql->execute();
			return $sql->fetchAll();
		}

		/*
			Limpa pessoas online
		*/

		public static function limparUsuariosOnline(){
			$date = date('Y-m-d H:i:s');
			$sql = MySql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$date' - INTERVAL 1 MINUTE");
		}


		/*
			Alerta de ação dos formularios 
		*/

		public static function alert($tipo,$mensagem){
			switch ($tipo) {
				case 'sucesso':
					echo '<div class="box-alert sucesso"><i class="fa fa-check"></i> '.$mensagem.'</div>';
					break;
				
				case 'erro':
					echo '<div class="box-alert erro"><i class="fa fa-times"></i> '.$mensagem.'</div>';
					break;
				case 'atencao':
					echo '<div class="box-alert atencao"><i class="fas fa-exclamation-triangle"></i> '.$mensagem.'</div>';
					break;
			}
			
		}

		/*
			Alerta de JavaScript
		*/

		public static function alertJS($msg){
			echo '<script>alert("'.$msg.'")</script>';
		}

		/*
			Validaão de imagens com limite de tamanho por KB
		*/


		public static function imagemValida($imagem){
			if($imagem['type'] == 'image/jpeg' ||
				$imagem['type'] == 'image/jpg' ||
				$imagem['type'] == 'image/png'){

				$tamanho = intval($imagem['size']/1024);
				if($tamanho < 900)
					return true;
				else
					return false;
			}else{
				return false;
			}
		}

		/*
			Adiciona imagem no arquivo uploads
		*/
		
		public static function uploadFile($file){
			$formatoArquivo = explode('.',$file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL_ADMIN.'/uploads/'.$imagemNome))
				return $imagemNome;
			else
				return false;
		}

		/*
			Adiciona imagem de produto
		*/
		
		public static function uploadFileProduto($file){
			$formatoArquivo = explode('.',$file['name']);
			$imagemNome = Painel::formatarNomeIMG($file['name']);
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL_ADMIN.'/produtos/'.$imagemNome))
				return $imagemNome;
			else
				return false;
		}

		public static function imagemCategoriaValida($imagem){
			if($imagem['type'] == 'image/jpeg' ||
			   $imagem['type'] == 'image/jpg' ||
			   $imagem['type'] == 'image/png' ||
			   $imagem['type'] == 'image/svg+xml'){
				$tamanho = intval($imagem['size']/1024);
				if($tamanho < 1000)
					return true;
				else
					return false;
			}else{
				return false;
			}
		}

		/*
			Adiciona imagem no arquivo uploads
		*/
		
		public static function uploadCategoriaFile($file){
			$formatoArquivo = explode('.',$file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL_ADMIN.'/uploadsmenu/'.$imagemNome))
				return $imagemNome;
			else
				return false;
		}

		/*
			Adiciona foto no perfil no arquivo uploads
		*/

		public static function uploadPerfil($file){
			$formatoArquivo = explode('.',$file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL_ADMIN.'/uploads/'.$imagemNome))
				return $imagemNome;
			else
				return false;
		}

		/*
			Deletar imagem no arquivo uploads
		*/
		
		public static function deleteFile($file){
			@unlink('uploads/'.$file);
		}

		/*
			Deletar imagem no arquivo uploadsmenu
		*/
		
		public static function deletemenuFile($file){
			@unlink('uploadsmenu/'.$file);
		}
		/*
			Inserir tabela
		*/

		public static function insert($arr){
			$certo = true;
			$nome_tabela = $arr['nome_tabela'];
			$query = "INSERT INTO `$nome_tabela` VALUES (null";
			foreach ($arr as $key => $value) {
				$nome = $key;
				$valor = $value;
				if($nome == 'acao' || $nome == 'nome_tabela')
					continue;
				if($value == ''){
					$certo = false;
					break;
				}
				$query.=",?";
				$parametros[] = $value;
			}

			$query.=")";
			if($certo == true){
				$sql = MySql::conectar()->prepare($query);
				$sql->execute($parametros);
				$lastId = MySql::conectar()->lastInsertId();
				$sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET order_id = ? WHERE id = $lastId");
				$sql->execute(array($lastId));
			}
			return $certo;
		}

		/*
			Atualizar tabela
		*/

		public static function update($arr,$single = false){
			$certo = true;
			$first = false;
			$nome_tabela = $arr['nome_tabela'];

			$query = "UPDATE `$nome_tabela` SET ";
			foreach ($arr as $key => $value) {
				$nome = $key;
				$valor = $value;
				if($nome == 'acao' || $nome == 'nome_tabela' || $nome == 'id')
					continue;
				if($value == ''){
					$certo = false;
					break;
				}
				
				if($first == false){
					$first = true;
					$query.="$nome=?";
				}
				else{
					$query.=",$nome=?";
				}

				$parametros[] = $value;
			}

			if($certo == true){
				if($single == false){
					$parametros[] = $arr['id'];
					$sql = MySql::conectar()->prepare($query.' WHERE id=?');
					$sql->execute($parametros);
				}else{
					$sql = MySql::conectar()->prepare($query);
					$sql->execute($parametros);
				}
			}
			return $certo;
		}

		/*
			Selecionar e ordena uma lista de uma tabela para o revendedor
		*/

		public static function selectLojaAll($tabela,$start = null,$end = null){
			if($start == null && $end == null)
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY loja_id ASC");
			else
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY loja_id ASC LIMIT $start,$end");
	
			$sql->execute();
			
			return $sql->fetchAll();

		}

		/*
			Selecionar e ordena uma lista de uma tabela para o colaborado
		*/

		public static function selectAll($tabela,$start = null,$end = null){
			if($start == null && $end == null)
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC");
			else
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC LIMIT $start,$end");
	
			$sql->execute();
			
			return $sql->fetchAll();

		}

		/*
			Selecionar e item uma lista de uma tabela
		*/

		public static function selectItem($tabela,$start = null,$end = null){
			if($start == null && $end == null)
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY id ASC");
			else
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY id ASC LIMIT $start,$end");
	
			$sql->execute();
			
			return $sql->fetchAll();

		}

		/*
			Deletar uma informação de uma tabela
		*/

		public static function deletar($tabela,$id=false){
			if($id == false){
				$sql = MySql::conectar()->prepare("DELETE FROM `$tabela`");
			}else{
				$sql = MySql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
			}
			$sql->execute();
		}

		/*
			Redirecionar a pessoa para uma pagina
		*/

		public static function redirect($url){
			echo '<script>location.href="'.$url.'"</script>';
			die();
		}

		/*
			Metodo especifico para selecionar apenas 1 registro.
		*/

		public static function select($table,$query = '',$arr = ''){
			if($query != false){
				$sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $query");
				$sql->execute($arr);
			}else{
				$sql = MySql::conectar()->prepare("SELECT * FROM `$table`");
				$sql->execute();
			}
			return $sql->fetch();
		}

		/*
			Metodo especifico para selecionar multiplos registros com base na query.
		*/

		public static function selectQuery($table,$query = '',$arr = ''){
			if($query != false){
				$sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $query");
				$sql->execute($arr);
			}else{
				$sql = MySql::conectar()->prepare("SELECT * FROM `$table`");
				$sql->execute();
			}
			return $sql->fetchAll();
		}

		/*
			Ordenar item de uma tabela atraves do ordee_id
		*/

		public static function orderItem($tabela,$orderType,$idItem){
			if($orderType == 'up'){
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$order_id = $infoItemAtual['order_id'];
				$itemBefore = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id < $order_id ORDER BY order_id DESC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0)
					return;
				$itemBefore = $itemBefore->fetch();
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
			}else if($orderType == 'down'){
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$order_id = $infoItemAtual['order_id'];
				$itemBefore = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id > $order_id ORDER BY order_id ASC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0)
					return;
				$itemBefore = $itemBefore->fetch();
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
			}
		}
		/*
			Redireicionar o usuario para uma pagina em um curto periodo
		*/
		public static function redirecionar($dir){
			echo "<meta http-equiv='refresh' content='3; url={$dir}'>";
			die();
		}
	}

?>