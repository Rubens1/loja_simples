<div class="perfil-container">
	<div class="mensagem">
		<div class="mensagem-viws">
	<?php 


		if(isset($_POST['acao'])){

		$nome = $_POST['nome'];
		$sobrenome = $_POST['sobrenome'];
		$email = $_POST['email'];
		$cpf = $_POST['cpf'];
		if(Consumido::cpfExists($cpf)){
			Painel::alert('erro','CPF já cadastrado');
		}else if(Consumido::consumidoAtualizadoExists($email)){
			Painel::alert('erro','Email já cadastrado');
		}else if(Consumido::atualizarConsumido($nome,$sobrenome,$email,$cpf)){
			Painel::alert('sucesso','Informações atualizado com sucesso!');
		}else{
			Painel::alert('erro','Ocorreu um erro ao atualizar...');
		}
	}
	$id_consumidor = $_SESSION['id_usuario'];
	$consumido = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.informacoes` WHERE id = $id_consumidor");
	$consumido->execute();
	$consumido = $consumido->fetch();

	?>
		</div><!--mensagem-viws-->
	</div><!--mensagem-->

		<h1> Informações da conta</h1>
		<form method="post">
			<div class="info-cliente">
				<label>Nome:</label>
				<input type="text" name="nome" value="<?php echo $consumido['nome']; ?>"> 
			</div><!--info-cliente-->
			<div class="info-cliente">
				<label>Sobrenome:</label>
				<input type="text" name="sobrenome" value="<?php echo $consumido['sobrenome']; ?>">
			</div><!--info-cliente-->
			<div class="info-cliente">  
				<label>Email:</label>
				<input type="email" name="email" value="<?php echo $consumido['email']; ?>"> 
			</div><!--info-cliente-->
			<div class="info-cliente">  
				<label>CPF:</label>
				<input type="text" name="cpf" value="<?php echo $consumido['cpf']; ?>"> 
			</div><!--info-cliente-->

			<div class="center">
				<input type="submit" name="acao" value="Salvar">
			</div><!--center-->
	</form>
 <div class="enderecos">
	 <div class="endereco_container">
		 <div class="link_endereco">
		 	<a href="<?php echo INCLUDE_PATH_PAINEL_CLIENTE;?>adicionar_endereco">Adicionar endereço de entrega</a> 
		 </div>
		 <?php 
		 if(isset($_GET['endereco_deletado'])){
			$id_endereco = $_GET['endereco_deletado'];
			MySql::conectar()->exec("DELETE FROM `tb_cliente.endereco` WHERE id = '$id_endereco'");
			Painel::alert('sucesso','Endereço deletado com sucesso');
			 }
			 ?>
		 <div class="todos_enderecos">
			 <?php 
			 $endereco = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.endereco` WHERE id_cliente = ?");
			 $endereco->execute(array($id_consumidor));
			 $endereco_todas = $endereco->fetchAll();
			 $total = $endereco->rowCount();
			 foreach ($endereco_todas as $key => $value) { ?>
			 <div class="endereco_cliente">
				 <p><b>CEP:</b><?php echo $value['cep'];?></p>
				 <p><b>Estado:</b><?php echo $value['estado'];?></p>
				 <p><b>Cidade:</b><?php echo $value['cidade'];?></p>
				 <p><b>Bairro:</b><?php echo $value['bairro'];?></p>
				 <p><b>Rua:</b><?php echo $value['rua'];?></p>
				 <p><b>Complemento:</b><?php echo $value['complemento'];?></p>
				 <p><b>Numero:</b><?php echo $value['numero'];?></p>
				 <div class="botoes_endereco">
					 <a href="<?php echo INCLUDE_PATH_PAINEL_CLIENTE?>editar_endereco?endereco=<?php echo $value['id'];?>" class="editar_endereco">Editar</a>
					<?php 
					
						if($total > 1){
					?>
					 <a href="<?php echo INCLUDE_PATH_PAINEL_CLIENTE?>meuperfil?endereco_deletado=<?php echo $value['id'];?>" class="apagar_endereco">Apagar</a>
				 	<?php } ?>
					</div><!--botoes_endereco-->
			 </div><!--endereco_cliente-->
			 <?php } ?>
		 </div><!--todos_enderecos-->
	 </div><!--endereco_container-->
 </div><!--enderecos-->
</div><!--perfil-container-->
