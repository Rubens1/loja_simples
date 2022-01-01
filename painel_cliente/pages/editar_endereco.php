<div class="perfil-container">

<?php
if(isset($_POST['acao'])){
	$cep = $_POST['cep'];
	$estado = $_POST['estado'];
	$cidade = $_POST['cidade'];
	$bairro = $_POST['bairro'];
	$rua = $_POST['rua'];
	$complemento = $_POST['complemento'];
	$numero = $_POST['numero'];
	Consumido::atualizarEndereco($cep,$estado,$cidade,$bairro,$rua,$complemento,$numero);
	Painel::alert('sucesso','Endereço atualizado com sucesso');
}
	$id_endereco = $_GET['endereco'];
	$consumido = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.endereco` WHERE id = $id_endereco");
	$consumido->execute();
	$endereco = $consumido->fetch();
		?>

		<h1> Editar Endereço</h1>
		<form method="post">
			<div class="info-cliente">
				<label>Cep:</label>
				<input type="text" name="cep" value="<?php echo $endereco['cep']; ?>"> 
			</div><!--info-cliente-->
			<div class="info-cliente">
				<label>Estado:</label>
				<input type="text" name="estado" value="<?php echo $endereco['estado']; ?>">
			</div><!--info-cliente-->
			<div class="info-cliente">
				<label>Cidade:</label>
				<input type="text" name="cidade" value="<?php echo $endereco['cidade']; ?>">
			</div><!--info-cliente-->
            <div class="info-cliente">
				<label>Bairro:</label>
				<input type="text" name="bairro" value="<?php echo $endereco['bairro']; ?>">
			</div><!--info-cliente-->
            <div class="info-cliente">
				<label>Rua:</label>
				<input type="text" name="rua" value="<?php echo $endereco['rua']; ?>">
			</div><!--info-cliente-->
            <div class="info-cliente">
				<label>Complemento:</label>
				<input type="text" name="complemento" value="<?php echo $endereco['complemento']; ?>">
			</div><!--info-cliente-->
            <div class="info-cliente">
				<label>Número:</label>
				<input type="text" name="numero" value="<?php echo $endereco['numero']; ?>">
			</div><!--info-cliente-->
			<div class="center">
				<input type="submit" name="acao" value="Editar Endereço">
			</div><!--center-->
	</form>
</div><!--perfil-container-->