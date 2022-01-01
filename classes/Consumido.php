<?php 

	class Consumido{
		/*
			Atualizar informações do cadastro do cliente
		*/
		public function atualizarConsumido($nome,$sobrenome,$email,$cpf){
			$sql = MySql::conectar()->prepare("UPDATE `tb_cliente.informacoes` SET nome = ?,sobrenome = ?,email = ?,cpf = ? WHERE email = ?");
			if($sql->execute(array($nome,$sobrenome,$email,$cpf,$_SESSION['email']))){
				return true;
			}else{
				return false;
			}
		}
		/*
			Atualizar endereço do cadastro do cliente
		*/
		public function atualizarEndereco($cep,$estado,$cidade,$bairro,$rua,$complemento,$numero){
			$sql = MySql::conectar()->prepare("UPDATE `tb_cliente.endereco` SET cep = ?,estado = ?,cidade = ?,bairro = ?,rua = ?, complemento = ?,numero = ? WHERE id_cliente = ?");
			if($sql->execute(array($cep,$estado,$cidade,$bairro,$rua,$complemento,$numero,$_SESSION['id_usuario']))){
				return true;
			}else{
				return false;
			}
		}
		/*
			Verifica se existe o consumidor no banco de dados
		*/
		public static function consumidoAtualizadoExists($email){
			$sql = MySql::conectar()->prepare("SELECT id FROM `tb_cliente.informacoes` WHERE email=? AND email <> ?");
			$sql->execute(array($email,$_SESSION['email']));
			if($sql->rowCount() == 1)
				return true;
			else
				return false;
		}
		/*
			Verifica se existe o consumidor no banco de dados
		*/
		public static function consumidoExists($email){
			$sql = MySql::conectar()->prepare("SELECT id FROM `tb_cliente.informacoes` WHERE email=? ");
			$sql->execute(array($email));
			if($sql->rowCount() == 1)
				return true;
			else
				return false;
		}
		/*
			Verifica se o cpf já foi cadastrado
		*/
		public static function cpfExists($cpf){
			$sql = MySql::conectar()->prepare("SELECT cpf FROM `tb_cliente.informacoes` WHERE cpf = ? AND id <> ?");
			$sql->execute(array($cpf,$_SESSION['id_usuario']));
			if($sql->rowCount() == 1)
				return true;
			else
				return false;
		}
		/*
			Cadastra um cliente
		*/
		public static function cadastrarConsumido($nome,$sobrenome,$email,$cpf,$senha){
			$sql = MySql::conectar()->prepare("INSERT INTO `tb_cliente.informacoes` VALUES (null,?,?,?,?,?)");
			$sql->execute(array($nome,$sobrenome,$email,$cpf,$senha));
			
		}
		/*
			Cadastrar um endereço do cliente
		*/
		public static function cadastrarEndereco($cep,$estado,$cidade,$bairro,$rua,$complemento,$numero){
			$sql = MySql::conectar()->prepare("INSERT INTO `tb_cliente.endereco` VALUES (null,?,?,?,?,?,?,?,?)");
			$sql->execute(array($_SESSION['id_usuario'],$cep,$estado,$cidade,$bairro,$rua,$complemento,$numero));
			
		}
		/*
			Verifica se o cpf é valido
		*/
		public static function isCpf($cpf){
			$cpf = preg_replace("/[^0-9]/", "", $cpf);
			$digitoUm = 0;
			$digitoDois = 0;

			for($i = 0, $x = 10; $i <= 8; $i++, $x--){
				$digitoUm += $cpf[$i] * $x;
			}

			for($i = 0, $x = 11; $i <= 9; $i++, $x--){
				if(str_repeat($i, 11) == $cpf){
					return false;
				}
				$digitoDois += $cpf[$i] * $x;
			}

			$calculoUm = (($digitoUm%11) < 2 ? 0 : 11 -($digitoUm%11));
			$calculoDois = (($digitoDois%11) < 2 ? 0 : 11 -($digitoDois%11));
			if($calculoUm <> $cpf[9] || $calculoDois <> $cpf[10]){
				return false;
			}else{
				return true;
			}
		}
		/*
			Verifica cliente para alterar a senha
		*/
		public static function verificaDados($email){
			if(isset($_POST['enviar']) && $_POST['enviar'] == 'form'){
				$email = addslashes($_POST['email']);
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.informacoes` WHERE email=?");
				$sql->execute(array($email));
				if($sql->rowCount() > 0){
					Consumido::add_dados_racover($email);
					
				}else{
					echo Painel::alert('erro','Digite um email cadastrado');
				}
			}
		}
		/*
			adicionar uma solicitação de atualizar senha
		*/
		public static function add_dados_racover($email){
			$rash = md5(rand());
			$sql = MySql::conectar()->prepare("INSERT INTO `recover_solicitado` VALUES (null,?,?)");
			$sql->execute(array($email,$rash));

			if($sql->rowCount() > 0){
				Consumido::enviarEmail($email,$rash);
			}else{

			}
		}
		/*
			Enviar um email para o cliente recuperar a senha por um link unico e temporario
		*/
		public static function enviarEmail($email,$rash){
			$mail = new Email('labdevelop.com.br','rubens.jesus@labdevelop.com.br','Ru19051997','Glitec');
			$mail->addAdress($email,'Pedido de uma nova senha');
			$subject = "RECUPERAR SENHA";
			$messege = '<html><head>';
			
				$messege .= "
			<h2>Você solicitou uma nova senha</h2>
			<h3>Entre nesse link para altera a senha: </h3><p><a href='".INCLUDE_PATH_REGISTRO."alterar&rash={$rash}'>".INCLUDE_PATH_REGISTRO."alterar&rash={$rash}</a></p>
			<hr>
			<p>Atenciosamente, GLITEC.</p>
			";
			$messege .='</html></head>';
			
			$info = array('assunto'=>$subject,'corpo'=>$messege);	
			$mail->formatarEmail($info);

			if($mail->enviarEmail()){
				echo Painel::alert('sucesso','Uma nova senha foi enviado');
			}else{
				echo Painel::alert('erro','Erro ao enviar o link de alteração da senha');
			}
		}
		/*
			verifica o resultado da solicitação
		*/
		public static function verificaRash($rash){
			
			$alterar = MySql::conectar()->prepare("SELECT * FROM `recover_solicitado` WHERE rash=?");
			$alterar->execute(array($rash));
			if($alterar->rowCount() > 0){
				if(isset($_POST['env']) && $_POST['env'] == 'upd'){
					$senha_sem_cript = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
					$novasenha = addslashes(password_hash($senha_sem_cript,PASSWORD_DEFAULT));
					$dados = $alterar->fetch()['email'];
					Consumido::atualizarSenha($dados,$novasenha);
					Consumido::deletarRash($dados);
					echo Painel::alert('sucesso','Senha alterada com sucesso.');
					Consumido::redirecionarConsumidor(INCLUDE_PATH);
				}
			}else{
				Consumido::redirecionarConsumidorErro(INCLUDE_PATH);

			}
		}
		/*
			Atualizar a senha
		*/
		public static function atualizarSenha($email,$senha){
			$atualizar = MySql::conectar()->prepare("UPDATE `tb_cliente.informacoes` SET senha = ? WHERE email = ?");
			$atualizar->execute(array($senha, $email));

			if($atualizar->rowCount() > 0){
				return true;
			}else{
				return false;
			}

		}
		/*
			Deletar a solicitação
		*/
		public static function deletarRash($email){
			$atualizar = MySql::conectar()->prepare("DELETE FROM `recover_solicitado` WHERE email = ?");
			$atualizar->execute(array($email));

			if($atualizar->rowCount() > 0){
				return true;
			}else{
				return false;
			}
		}
		/*
			Redirecionar o cliente apos ter trocado a asenha com sucesso
		*/
		public static function redirecionarConsumidor($dir){
			echo "<meta http-equiv='refresh' content='3; url={$dir}'>";
		}
		/*
			Redirecionar o cliente apos ter trocado a asenha com erro
		*/
		public static function redirecionarConsumidorErro($dir){
			echo "<meta http-equiv='refresh' content='0; url={$dir}'>";
		}
	}
 ?>