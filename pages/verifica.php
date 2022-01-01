<?php 

if(Painel::consumido_logado()){
	echo Painel::redirect(INCLUDE_PATH.'pagamento');
}else{
	if(isset($_POST['acao']) && $_POST['acao'] == 'logar'){
		    $email = strip_tags(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
			$senha = strip_tags(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.informacoes` WHERE email = ?");
            $sql->execute(array($email));
            $info = $sql->fetch();
            @$senhalogin = $info['senha'];
                if(password_verify($senha,$senhalogin)){
                     if($sql->rowCount() == 1){
                     	 $_SESSION['consumido'] = true;
                     	 $_SESSION['id_usuario'] = $info['id'];
						  echo Painel::redirect(INCLUDE_PATH.'pagamento');
					}
                }else{
						echo '<script> alert("Desculpe, mais o usuário não foi encontrado");location.href="'.INCLUDE_PATH.'verifica"</script>';
					}
            }
	}
 ?>

<div class="container">
<div class="verification" id="verification">
	
	<div class="logar">
		<form  action="" method="post" enctype="multipat/form-data">
			 <?php 

            if(isset($_POST['loga'])){
                 if(!password_verify($senha,$senhalogin)){
                    echo Painel::alert('erro',' Email ou senha incorretos!'); 
                    $senha_sem_cript = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
                        $senha = password_hash($senha_sem_cript,PASSWORD_DEFAULT);
                       // echo $senha;               
                 }                    
            }
             ?>
			<label>Email</label>
			<input class="form-login" type="email" name="email">
			<label>Senha</label>
			<input class="form-login" type="password" name="senha">
			<input type="hidden" name="acao" value="logar">
			<input class="btn-login" type="submit" value="Entrar">
			<a class="senha" href="<?php echo INCLUDE_PATH; ?>recuperar_senha">Equeci a senha</a>
		</form><!--Formulario de login-->
	</div><!--Logar-->
	<div class="text">
		<span>Ainda não é cadastrado?</span>
		<p>Se você não é cadastrado se cadastra para finalizar a sua compra </p>
		<p><a href="<?php echo INCLUDE_PATH; ?>cadastro">Clique aqui</a></p>
	</div><!--Text-->
</div><!--Verification-->
</div><!--container-->