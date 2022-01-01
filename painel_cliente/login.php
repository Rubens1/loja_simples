
<?php 
include('../pages/includes/header.php');

if(isset($_POST['loga'])){
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.informacoes` WHERE email = ?");
	$sql->execute(array($email));
	$info = $sql->fetch();
	$senhalogin = @$info['senha'];
	if(password_verify($senha,$senhalogin)){
			if($sql->rowCount() == 1){
				$_SESSION['consumido'] = true;
				$_SESSION['email'] = $email;
				$_SESSION['senha'] = $senha;
				$_SESSION['id_usuario'] = $info['id'];
				$_SESSION['nome'] = $info['nome'];
				echo Painel::redirect(INCLUDE_PATH);
				die();
			}
	}

}

 ?>
<div class="container-login">
<div class="verification" id="verification">
	
	<div class="logar">
		<form action="" method="post" enctype="multipat/form-data">
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
			<input name="loga" class="btn-login" type="submit" value="Entrar">
			<div class="senha">
				<a href="<?php echo INCLUDE_PATH; ?>recuperar_senha">Equeci a senha</a>
			</div><!--SEnha-->
		</form><!--Formulario de login-->
	</div><!--Logar-->
	<div class="text">
		<span>Ainda não é cadastrado?</span>
		<p>Se você não é cadastrado se cadastra para finalizar a sua compra </p>
		<p><a href="<?php echo INCLUDE_PATH; ?>cadastro">Clique aqui</a></p>
	</div><!--Text-->
</div><!--Verification-->
</div><!--container-->
     
<?php 
include('../pages/includes/footer.php');
 ?>
   <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL_CLIENTE; ?>js/login.js"></script>

