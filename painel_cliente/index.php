<?php 
include('../config.php'); 

  if(Painel::consumido_logado() == false){
    include('login.php');
  }else{
    include('main.php');
  }
     
  ?>



