<div class="site-menu">
    <div class="containe-menu">
        <div class="cadastro-categoria">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Cadastre uma categoria/menu</h1>
                <?php
               

                if(isset($_POST['acao'])){
                    $nome = $_POST['nome'];
                    $categoria = $_POST['categoria_id'];
                    if($nome == ''){
                        Painel::alert('erro','O campo nome não pode ficar vázio!');
                    }else if($nome == ''){
                        Painel::alert('erro','Selecione uma categoria');
                    }else{
                        //Apenas cadastrar no banco de dados!
                        $verificar = MySql::conectar()->prepare("SELECT * FROM `tb_admin.subcategoria` WHERE nome = ? AND categoria_id =?");
                        $verificar->execute(array($nome,$categoria));
                        if($verificar->rowCount() == 0){
                                $slug = Painel::generateSlug($nome);
                                $arr = ['categoria_id'=>$categoria,'nome'=>$nome,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_admin.subcategoria'];
                                Painel::insert($arr);
                                Painel::alert('sucesso','O cadastro da subcategoria foi realizado com sucesso!');
                        

                            
                        }else{
                            Painel::alert("erro",'Já existe uma subcategoria com este nome!');
                        }
                    }
                    
                }
                if(isset($_GET['deletar'])){
                    
                    $id = (int)$_GET['deletar'];
                    MySql::conectar()->exec("DELETE FROM `tb_admin.subcategoria` WHERE id = $id");
                    Painel::alert('sucesso','Subcategoria detetado com sucesso!');
                    
                }
            ?>
                <div class="input-form">
                    <input type="text" name="nome"  placeholder="Digita o nome da categoria">
                    <select name="categoria_id">
                        <?php
                            $categorias = Painel::selectAll('tb_admin.categorias');
                            foreach ($categorias as $key => $value) {
                        ?>
                        <option value="<?php echo $value['id'] ?>"><?php echo $value['nome']; ?></option>
                        <?php } ?>
                    </select>
                </div><!--Input-form-->
                <input type="submit" name="acao" class="cadastro botao-azul">
            </form>
        </div><!--Cadastro-categoria-->
        <h1>Lista Subcategoria/Submenu</h1>
        
        <div class="painel_lista">
                <div class="info_painel">
                    <div class="lista-itens">
                        <div class="lista-item">
                        <div class="titulo_painel">
                        <div class="coluna_info_painel">Nome</div><!--coluna_info_painel-->
                        <div class="coluna_info_painel">Categoria</div><!--coluna_info_painel-->
                        <div class="coluna_info_painel">Ação</div><!--coluna_info_painel-->
                    </div><!--Titulo_paine-->
                    <?php
                        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.subcategoria`");
                        $sql->execute();
                        $subcategoria = $sql->fetchAll();
                        foreach ($subcategoria as $key => $value) {
                            $categoria = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias` WHERE id = ?");
                            $categoria->execute(array($value['categoria_id']));
                            $categoria = $categoria->fetchAll();
                    ?>
                    <div class="info_painel">
                        <div class="coluna_info_painel"><?php echo $value['nome']; ?></div><!--coluna_info_painel-->
                        <div class="coluna_info_painel"><?php foreach ($categoria as $key => $value2) { echo $value2['nome']; } ?></div><!--coluna_info_painel-->
                        <div class="coluna_info_painel">
                        <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>subcategorias?deletar=<?php echo $value['id']; ?>" class="btn botao-vermelho"><i class="far fa-trash-alt"></i> Excluir</a>
                        </div><!--coluna_info_painel-->
                    </div><!--info_painel-->  
                    <?php } ?>
                    </div><!--Lista-item-->
                </div><!--Lista-itens-->
            </div><!--Info_painel-->
        </div><!--Painel_lista-->
    </div><!--Containe-menu-->
</div><!--Site-menu-->
