<?php

	include('../../config.php');
	$data['sucesso'] = true;
	$data['mensagem'] = "";

	if(Painel::logado() == false){
		die("Você não está logado!");
	}
	
    if(isset($_POST['tipo_acao']) && $_POST['tipo_acao'] == 'deletar_usuario'){
    		$id = $_POST['id'];
    
    		$sql = MySql::conectar()->prepare("SELECT img FROM `tb_admin.usuarios` WHERE id = $id");
    		$sql->execute();
    		$imagem = $sql->fetch()['img'];
    		@unlink('../uploads/'.$imagem);
    		MySql::conectar()->exec("DELETE FROM `tb_admin.usuarios` WHERE id = $id");
    	}

	die(json_encode($data));



?>