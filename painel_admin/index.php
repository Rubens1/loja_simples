<?php
	
	include('../config.php');

	if(Painel::admin_logado() == false){
		include('login.php');
	}else{
		include('main.php');
	}

?>