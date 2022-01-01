<?php
include('../../config.php');
        $user = $_POST['user'];
        $senha = $_POST['senha'];
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuario` WHERE user = ?");
        $sql->execute(array($user));
        $info = $sql->fetch();
        $senhalogin = $info['senha'];
        if(password_verify($senha,$senhalogin)){
                if($sql->rowCount() == 1){
                    $_SESSION['login_admin'] = true;
                    $_SESSION['user'] = $user;
                    $_SESSION['senha'] = $senha;
                    $_SESSION['cargo'] = $info['cargo'];
                    $_SESSION['id'] = $info['id'];
                    $_SESSION['nome'] = $info['nome'];
                    $_SESSION['img'] = $info['img'];
                    header('Location: '.INCLUDE_PATH_PAINEL_ADMIN);
                    die();
                    
                }
        }else{
            //Falhou
            echo Painel::alertJS('Usuário ou senha invalida');
            echo Painel::redirect(INCLUDE_PATH_PAINEL_ADMIN);
        }
    
?>