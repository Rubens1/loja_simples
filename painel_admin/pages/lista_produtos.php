<?php 
	if(isset($_GET['pendentes']) == false){
 ?>
<div class="produto_containe">
	<div class="produto_box">
		<div class="titulo_produto">
			<h1>Lista de Produtos</h1>
		</div><!-- Titulo Produto -->
		<div class="produto_busca">
			<form method="post">
				<input class="pesquisa_produto" type="text" name="pesquisa"  placeholder="Digita o nome ou código do produto">
				<input class="botao-azul busca" type="submit" name="acao" value="Busca">
			</form>
		</div><!-- Produto Busca -->
		<?php 

			if(isset($_GET['deletar'])){
				$id = (int)$_GET['deletar'];
				$imagens = MySql::conectar()->prepare ("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
				$imagens->execute();
				$imagens = $imagens->fetchAll();
				foreach ($imagens as $key => $value) {
					@unlink(BASE_DIR_PAINEL.'/uploads/'.$value['imagem']);
				}
				MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
				MySql::conectar()->exec("DELETE FROM `tb_admin.estoque` WHERE id = $id");
				Painel::alert('sucesso','O produto foi deletado do estoque com sucesso');
			}

			if(isset($_POST['atualizar'])){
				$quantidade = $_POST['quantidade'];
				$produto_id = $_POST['produto_id'];
				$pega_dados = \MySQL::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
				$pega_dados->execute(array($produto_id));
				$dados = $pega_dados->fetch();
				if($quantidade < 0){
					Painel::alert('erro','Você não pode cadastra quantidade para igual ou menor a 0!');
				}else{
					$nomeProduto = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
					$nomeProduto->execute(array($produto_id));
					$produto = $nomeProduto->fetch()['nome'];
					MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
					Painel::alert('sucesso','Você atualizou a quantidade do produto '.$produto);
				}
			}


			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
			$sql->execute();
			if($sql->rowCount() > 0){
			Painel::alert('atencao', 'Você está com produtos em falta! Clique <a href="'.INCLUDE_PATH_PAINEL_ADMIN.'lista_produtos?pendentes">aqui</a> para visualizar-los');
			}
			?>
		<div class="lista_produto">
			<div class="table_produto">
			<?php 
			$query = "";
			if(isset($_POST['acao']) && $_POST['acao'] == 'Busca'){
				$nome = $_POST['pesquisa'];
				$query = "WHERE (nome LIKE '%$nome%' OR codigo LIKE '%$nome%')";

			}
			if($query == ''){
				$query2 = "WHERE quantidade > 0";
			}else{
				$query2 = "AND quantidade > 0";
			}
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` $query $query2");
			$sql->execute();
			$produtos = $sql->fetchAll();
			if($query != ''){
					echo '<div style="width:100%" ><p>Foram encontrado(s):<b>'.count($produtos).'</b></p></div>';
				}
			foreach ($produtos as $key => $value) {
				$imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
				$imagemSingle->execute();
				$imagemSingle = $imagemSingle->fetch()['imagem'];
				$categoriaInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias` WHERE id = ?");
				$categoriaInfo->execute(array($value['id_categoria']));
				$categoria = $categoriaInfo->fetch();
				$subcategoriaInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.subcategoria` WHERE id = ?");
				$subcategoriaInfo->execute(array($value['id_subcategoria']));
				$subcategoria = $subcategoriaInfo->fetch();

				
		 ?>
				<div class="container_produto">
					<div class="img_produto">
						<img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN?>produtos/<?php echo $imagemSingle; ?>" alt="">
					</div><!-- Img Produto -->
					<div class="detalhe_produto">
						<p><b>Nome: <?php echo $value['nome']; ?></b></p>
						<p>Categoria: <b><?php echo $categoria['nome']; ?></b></p>
						<?php if($subcategoriaInfo->rowCount() == 1 && $subcategoria['categoria_id'] == $value['id_categoria']){ ?>
						<p>SubCategoria: <b><?php echo $subcategoria['nome']; ?></b></p>
						<?php } ?>
						<p>Quantidade: <b><?php echo $value['quantidade']; ?></b></p>
						<p>Vendas: <b><?php echo $value['vendido']; ?></b></p>
						<form class="form_atualizar" method="post">
							<label>Atualizar: </label>
							<input type="number" name="quantidade" min="0" max="9999" step="1" value="<?php echo $value['quantidade']; ?>">
						<input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
						<input class="btn botao-verde" type="submit" name="atualizar" value="Atualizar!">
					</form>
					<div class="botao_produtos">
						<a class="botao botao-azul" href="<?php echo INCLUDE_PATH_PAINEL_ADMIN?>editar_produto?id=<?php echo $value['id']; ?>"><i class="fas fa-pen"></i> Editar</a>
						<a class="botao botao-vermelho" href="<?php echo INCLUDE_PATH_PAINEL_ADMIN?>lista_produtos?deletar=<?php echo $value['id']; ?>"><i class="fas fa-trash"></i> Excluir</a>
					</div><!-- Botao Produtos -->
					</div><!-- Detalhe Produto -->
				</div><!-- Container Produto -->
				<?php } ?>
			</div><!-- Table Produto -->
		</div><!-- Lista Produto -->
	</div><!-- Produto Box -->
</div><!-- Produto Containe -->
<?php }else{ ?>
	<?php } ?>