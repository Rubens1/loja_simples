<div class="perfil-container">
<div class="mensagem">
		<div class="mensagem-viws">
	<?php 
		if(isset($_POST['acao'])){

		$cep = $_POST['cep'];
		$estado = $_POST['estado'];
		$cidade = $_POST['cidade'];
		$bairro = $_POST['bairro'];
        $rua = $_POST['rua'];
        $complemento = $_POST['complemento'];
        $numero = $_POST['numero'];
		Consumido::cadastrarEndereco($cep,$estado,$cidade,$bairro,$rua,$complemento,$numero);
        Painel::alert('sucesso','Endereço adicionado com sucesso');
        Painel::redirecionar('meuperfil');
	}
	?>
		</div><!--mensagem-viws-->
	</div><!--mensagem-->
<h1> Adiconar Endereço</h1>
		<form method="post" id="enderecoForm">
			<div class="info-cliente">
				<label>CEP:</label>
				<input id="cep" type="text" name="cep" value=""> 
			</div><!--info-cliente-->
			<div class="info-cliente">
				<label>Estado:</label>
				<input id="uf" type="text" name="estado" value="">
			</div><!--info-cliente-->
			<div class="info-cliente">  
				<label>Cidade:</label>
				<input id="cidade" type="text" name="cidade" value=""> 
			</div><!--info-cliente-->
            <div class="info-cliente">  
				<label>Bairro:</label>
				<input id="bairro" type="text" name="bairro" value=""> 
			</div><!--info-cliente-->
            <div class="info-cliente">  
				<label>Rua:</label>
				<input id="logradouro" type="text" name="rua" value=""> 
			</div><!--info-cliente-->
            <div class="info-cliente">  
				<label>Complemento:</label>
				<input type="text" name="complemento" value=""> 
			</div><!--info-cliente-->
            <div class="info-cliente">  
				<label>Numero:</label>
				<input type="text" name="numero" value=""> 
			</div><!--info-cliente-->

			<div class="center">
				<input type="submit" name="acao" value="Salvar">
			</div><!--center-->
	</form>
    </div><!--perfil-container-->