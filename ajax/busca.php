<?php
	include_once('../config.php');
	
    /*
        Alto inclemento do campo de adicionar rolos do produto no estoque que fica no modal da pagina adicionar
    */
       /* $pesquisa = filter_input(INPUT_POST, 'pesquisa', FILTER_SANITIZE_STRING);
        
        $sql = MySql::conectar()->prepare("SELECT nome,id,id_categoria,slug FROM `tb_admin.estoque` WHERE nome LIKE '%$pesquisa%'");
        $sql->execute();
        $resultado = $sql->fetchAll();
        if($sql->rowCount() == 0){
            echo Painel::alert('erro', 'Produto não encontrado');
        }?>
        <?php
        if(isset($_POST['pesquisa']) && $_POST['pesquisa'] != ''){
            foreach ($resultado as $key => $value) {
              $categoria = MySql::conectar()->prepare("SELECT `slug` FROM `tb_admin.categorias` WHERE id = ?");
              $categoria->execute(array($value['id_categoria']));
              $categoriaNome = $categoria->fetch()['slug'];
              $imagem = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id]");
              $imagem->execute();
              $imagem = $imagem->fetch()['imagem'];
  ?>
             <a href="<?php echo INCLUDE_PATH; ?>produto/<?php echo $categoriaNome; ?>/<?php echo $value['slug'];?>" class="busca_link"><img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>produtos/<?php echo $imagem;?>" alt=""><?php echo $value['nome']; ?></a>
                    <?php } }*/
                    
                    
                                
    if(isset($_GET["term"])){
        $pesquisa = $_GET["term"];
        $sql = MySql::conectar()->prepare("SELECT estoque.nome nome,estoque.id idProduto,estoque.slug slugProduto, categoria.slug slugCategoria FROM `tb_admin.estoque` estoque 
        INNER JOIN `tb_admin.categorias` categoria ON categoria.id = estoque.id_categoria 
        WHERE estoque.nome LIKE '%$pesquisa%'");
        $sql->execute();
        $resultado = $sql->fetchAll();
        $output = array();
            if($sql->rowCount() > 0){
                foreach($resultado as $row){

                    $imagem = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $row[idProduto]");
                    $imagem->execute();
                    $imagem = $imagem->fetch()['imagem'];
                    $temp_array = array();
                    $temp_array['value'] = $row['nome'];
                    $temp_array['label'] = ' 
                        <a href="'.INCLUDE_PATH.'produto/'.$row['slugCategoria'].'/'.$row['slugProduto'].'" class="busca_link">
                        <img src="'.INCLUDE_PATH_PAINEL_ADMIN.'produtos/'.$imagem.'">'.$row['nome'].'</a>
                   ';
                    $output[] = $temp_array;
                }
            }else{
                $output['value'] = '';
                $output['label'] = '<div class="erro_busca"><i class="fa fa-times"></i> Produto não encontrado</div>';
            }
            echo json_encode($output);
        }
?>  
    