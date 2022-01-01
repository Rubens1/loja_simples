<!DOCTYPE html>
<html>
<head>
	<title>Painel de controle</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>font/css/all.css">
	<link href="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>css/style.css" rel="stylesheet" />
	<link href="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>css/login.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php echo INCLUDE_PATH; ?>img/ico/ico.ico" type="image/x-icon">
</head>
<body>
<div class="containe-login">
	<div class="login">
			<div class="box-login">
				<h1>LOGO</h1>
				<form method="post" action="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>ajax/login.php">
					<input id="user" type="text" name="user" placeholder="Usuario..." required>
					<input id="senha" type="password" name="senha" placeholder="Senha..." required>
					<div class="form-group-login right">
					<div class="form-group-login">
						<input id="btn-login" type="submit" name="acao" value="Entrar">
					</div>
					
				</form>
			</div><!--box-login-->
		</div><!--login-->
	</div><!--containe-login-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/jquery.min.js"></script>

</body>
</html>