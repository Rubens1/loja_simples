<?php

    include('../../config.php');
    
    $categoria = $_REQUEST['id_categoria'];

    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.subcategoria` WHERE categoria_id = ? ORDER BY nome ASC");
    $sql->execute(array($categoria));
    $subcategorias = $sql->fetchAll();

    foreach ($subcategorias as $key => $value) {
        $resultao[] = array('id'	=> $value['id'],'nome' => $value['nome'],);
    }
 echo(json_encode($resultao));
 ?>