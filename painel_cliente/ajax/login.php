<?php
include('../../config.php'); 


if(isset($_POST['loga'])){
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.informacoes` WHERE email = ?");
            $sql->execute(array($email));
            $info = $sql->fetch();
            $senhalogin = $info['senha'];
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