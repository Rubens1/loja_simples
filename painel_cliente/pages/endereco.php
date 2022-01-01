<div class="perfil-container">
<div class="mensagem">
		<div class="mensagem-viws">
	<?php 
	
    $cep_compra = $_SESSION['cep_cadastro'];

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
        echo Painel::redirecionar(INCLUDE_PATH.'pagamento');
	}
	?>
		</div><!--mensagem-viws-->
	</div><!--mensagem-->
<h1> Cadastrar um endereço</h1>
		<form method="post" id="enderecoForm">
			<div class="info-cliente">
				<label>CEP:</label>
				<input id="cep" type="text" name="cep" value="<?php echo $cep_compra; ?>" require> 
			</div><!--info-cliente-->
			<div class="info-cliente">
				<label>Estado:</label>
				<input id="uf" type="text" name="estado" value="" require>
			</div><!--info-cliente-->
			<div class="info-cliente">  
				<label>Cidade:</label>
				<input id="cidade" type="text" name="cidade" value="" require> 
			</div><!--info-cliente-->
            <div class="info-cliente">  
				<label>Bairro:</label>
				<input id="bairro" type="text" name="bairro" value="" require> 
			</div><!--info-cliente-->
            <div class="info-cliente">  
				<label>Rua:</label>
				<input id="logradouro" type="text" name="rua" value="" require> 
			</div><!--info-cliente-->
            <div class="info-cliente">  
				<label>Complemento:</label>
				<input type="text" name="complemento" value=""> 
			</div><!--info-cliente-->
            <div class="info-cliente">  
				<label>Numero:</label>
				<input type="text" name="numero" value="" require> 
			</div><!--info-cliente-->

			<div class="center">
				<input type="submit" name="acao" value="Salvar">
			</div><!--center-->
	</form>
    </div><!--perfil-container-->