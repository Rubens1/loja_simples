<div class="site-menu">
    <div class="containe-menu">
        <div class="cadastro-categoria">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Cadastre uma categoria/menu</h1>
                <?php

                if(isset($_POST['acao'])){
                    $nome = $_POST['nome'];
                    $icone = $_POST['icone'];
                    if($nome == ''){
                        Painel::alert('erro','O campo nome não pode ficar vázio!');
                    }else if($icone == ''){
                        Painel::alert('erro','O campo icone não pode ficar vázio!');
                    }else{
                        //Apenas cadastrar no banco de dados!
                        $verificar = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias` WHERE nome = ?");
                        $verificar->execute(array($_POST['nome']));
                        if($verificar->rowCount() == 0){
                                $slug = Painel::generateSlug($nome);
                                $arr = ['nome'=>$nome,'icone'=>$icone,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_admin.categorias'];
                                Painel::insert($arr);
                                Painel::alert('sucesso','O cadastro da categoria foi realizado com sucesso!');
                        

                            
                        }else{
                            Painel::alert("erro",'Já existe uma categoria com este nome!');
                        }
                    }
                    
                }

                if(isset($_GET['deletar'])){
                    $id = $_GET['deletar'];
                    MySql::conectar()->exec("DELETE FROM `tb_admin.categorias` WHERE id = $id");
                    $subcategoria = MySql::conectar()->prepare ("SELECT * FROM `tb_admin.subcategoria` WHERE categoria_id = ?");
			        $subcategoria->execute(array($id));
			        $subcategoria = $subcategoria->fetchAll();
                    foreach ($subcategoria as $key => $value) {
                        MySql::conectar()->exec("DELETE FROM `tb_admin.subcategoria` WHERE categoria_id = $id");

                    }
                    Painel::alert('sucesso','Categoria detetado com sucesso!');

                }
            ?>
                <div class="input-form">
                    <input type="text" name="nome"  placeholder="Digita o nome da categoria">
                    <input type="text" name="icone"  placeholder="Digita o código do icone da categoria">
                </div><!--Input-form-->
                <input type="submit" name="acao" class="cadastro botao-azul">
            </form>
        </div><!--Cadastro-categoria-->
        <h1>Lista categoria/menu</h1>
        <div class="lista-menu">
        
            <?php
             $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias`");
             $sql->execute();
             $categoria = $sql->fetchAll();
             foreach ($categoria as $key => $value) {
            ?>
                <div class="menu-categoria">
                    <div class="icon">
                        <i class="<?php echo $value['icone']?>"></i>
                    </div>
                    <div class="detalhes-menu">
                        <p><?php echo $value['nome']?></p>
                        <div class="botao-grupo">
                        <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>categorias?deletar=<?php echo $value['id']; ?>" class="btn botao-vermelho"><i class="far fa-trash-alt"></i> Excluir</a>
                        <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>editar_categoria?id=<?php echo $value['id']; ?>" class="btn botao-amarelo"><i class="fas fa-upload"></i> Editar</a>
                        </div>
                    </div><!--Detalhes-menu-->
                </div><!--Menu-->
                <?php 
             }
                ?>
        </div><!--Lista-menu-->
    </div><!--Containe-menu-->
</div><!--Site-menu-->