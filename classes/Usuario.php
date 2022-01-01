<?php
	
	class Usuario{
		/*
			Atualizar usuario
		*/
		public function atualizarUsuario($nome,$imagem,$user){
			$sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuario` SET nome = ?, img = ?, user = ? WHERE user = ?");
			if($sql->execute(array($nome,$imagem,$user,$_SESSION['user']))){
				return true;
			}else{
				return false;
			}
		}
		/*
			Atualizar senha de usuario
		*/
		public function atualizarSenha($senha){
			$sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuario` SET senha = ? WHERE user = ?");
			if($sql->execute(array($senha,$_SESSION['user']))){
				return true;
			}else{
				return false;
			}
		}
		/*
			Verifica se existe o ususario
		*/
		public static function userExists($user){
			$sql = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.usuario` WHERE user=?");
			$sql->execute(array($user));
			if($sql->rowCount() == 1)
				return true;
			else
				return false;
		}
		/*
			Cadastrar usuario
		*/
		public static function cadastrarUsuario($user,$senha,$nome,$email,$imagem,$cargo){
			$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.usuario` VALUES (null,?,?,?,?,?)");
			$sql->execute(array($user,$senha,$nome,$imagem,$cargo));
		}

	}

?>