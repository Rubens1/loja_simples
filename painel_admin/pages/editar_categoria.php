<?php 

	$id = (int)$_GET['id'];
    if(isset($_POST['acao'])){
        $nome = $_POST['nome'];
        $icone = $_POST['icone'];
        if($nome == ''){
            Painel::alert('erro','Digita o nome da categoria!');
        }else{
            $slug = Painel::generateSlug($nome);
            $categorias = MySql::conectar()->prepare("UPDATE `tb_admin.categorias` SET nome = ?, icone = ?, slug = ? WHERE id = $id");
            $categorias->execute(array($nome,$icone,$slug));
            Painel::alert('sucesso','Categoria atualizado com sucesso');
        }
    }

    
	$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias` WHERE id = ?");
	$sql->execute(array($id));
	if($sql->rowCount() == 0){
		Painel::alert('erro','A Categoria que você quer editar não existe!');
		die();
	}
	$infoCategoria = $sql->fetch();

    
   
?>
<div class="site-menu">
    <div class="containe-menu">
        <div class="cadastro-categoria">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Editar categoria/menu</h1>
                <div class="input-form">
                    <input type="text" name="nome" placeholder="Digita o nome da categoria" value="<?php  echo $infoCategoria['nome']; ?>">
                    <input type="text" name="icone" placeholder="Digita o nome da categoria" value="<?php  echo $infoCategoria['icone']; ?>">
                </div><!--Input-form-->
                <input type="submit" name="acao" class="cadastro botao-azul" value="Editar">
            </form>
            
        </div><!--Cadastro-categoria-->
    </div><!--Containe-menu-->
</div><!--Site-menu-->