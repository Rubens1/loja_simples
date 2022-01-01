<?php 
	if(isset($_GET['pendentes']) == false){
 ?>
<div class="box-content">
	<h2>Lista de Produto</h2>
		<div class="busca">
		<h4>Realizar busca</h4>
		<form method="post">
			<input type="text" class="form-control" name="busca" placeholder="Procure pelo nome do produto ou codigo">
			<input type="submit" name="acao" value="Buscar!">
		</form>
	</div>
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
			$quantidade = $_POST['quantidade_total'];
			$produto_id = $_POST['produto_id'];
			$pega_dados = \MySQL::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
		    $pega_dados->execute(array($produto_id));
		    $dados = $pega_dados->fetch();
    		$qtd_cartoon = $dados['quantidade'];
    		$fornecedor_ids = $dados['fornecedor_id'];
    		$marca_ids = $dados['marca_id'];
    		$cartoons = 0;
			for ($i=0; $i <= $quantidade; $i+=$qtd_cartoon) { 
				if ($i <= $quantidade) {
					$cartoons++;  
				} 		      
			}
			if($quantidade < 0){
				Painel::alert('erro','Você não pode cadastra quantidade para igual ou menor a 0!');
			}else{
				MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade_total = $quantidade,cartoons = $cartoons WHERE id = $produto_id");
				MySql::conectar()->exec("UPDATE `tb_admin.lote` SET cartoons = $cartoons WHERE marca_id = $marca_ids AND fornecedor_id = $fornecedor_ids");
			Painel::alert('sucesso','Você atualizou a quantidade de um dos produtos ');
			}
		}


		$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade_total = 0");
		$sql->execute();
		if($sql->rowCount() > 0){
		Painel::alert('atencao', 'Você está com produtos em falta! Clique <a href="'.INCLUDE_PATH_PAINEL.'visualizar-produtos?pendentes">aqui</a> para visualizar-los');
		}
	 ?>
	<div class="boxes">
		<?php 
			$query = "";
			if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar!'){
				$nome = $_POST['busca'];
				$query = "WHERE (nome LIKE '%$nome%' OR codigo LIKE '%$nome%')";

			}
			if($query == ''){
				$query2 = "WHERE quantidade_total > 0";
			}else{
				$query2 = "AND quantidade_total > 0";
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
				$categoriaInfo->execute(array($value['categoria_id']));
				$categoria = $categoriaInfo->fetch();
				$subcategoriaInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.subcategoria` WHERE id = ?");
				$subcategoriaInfo->execute(array($value['subcategoria_id']));
				$subcategoria = $subcategoriaInfo->fetch();
				$fornecedorInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.fornecedor` WHERE id = ?");
				$fornecedorInfo->execute(array($value['fornecedor_id']));
				$fornecedor = $fornecedorInfo->fetch();

				
		 ?>
	
		<div class="box-single-wraper produtos">
			<div style="padding:8px 15px;height: 100%;" class="produtos">
				<div style="width: 100%;float: left;" class="box-imagem">
					<?php 
						if($imagemSingle == ''){
					?>
						<h1><i class="fas fa-shopping-basket"></i></h1>
					<?php
						}else{
					 ?>
				<img class="img-produto" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemSingle; ?>" />
				<?php } ?>
			</div>
			<div class="box-single">
			<div class="body-box">
				<p><b>Nome do Produto:</b> <?php echo $value['nome']; ?></p>
				<p><b>Código:</b><?php echo $value['codigo']; ?></p>
				<p><b>Categoria: </b><?php echo $categoria['nome']; ?></p>
				<p><b>SubCategoria: </b><?php echo $subcategoria['nome']; ?></p>
				<p><b>Fornecedor: </b> <?php echo $fornecedor['nome']; ?></p>
				<p><b>Preço: </b>R$ <?php echo Painel::convertMoney($value['preco']); ?></p>
								<p><b>Preço Atacado: </b>R$ <?php echo Painel::convertMoney($value['preco_atacado']); ?></p>

				<p><b>Cartoon: </b><?php echo $value['cartoons']; ?></p>
				<div class="group-btn" style="border-bottom: 1px solid #ccc;">
					<form method="post">
						<label>Quantidade atual: </label>
						<input type="number" name="quantidade_total" min="0" max="900" step="1" value="<?php echo $value['quantidade_total']; ?>">
						
						<input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
						<input type="submit" name="atualizar" value="Atualizar!">
					</form>
				</div>
				<div class="group-btn">
					<a item_id="<?php echo $value['id']; ?>" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL;?>visualizar-produtos?deletar=<?php echo $value['id'];?>"><i class="fa fa-times"></i> Excluir</a>
					<a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-produto?id=<?php echo $value['id'] ?> "><i class="fas fa-pencil-alt"></i> Editar</a>
				</div>
			</div>
		</div>
			
	  </div>
	</div>
	  <?php
		$_SESSION['quantidade'] = $value['quantidade'];
		$_SESSION['cartoons'] = $value['cartoons'];
	   } ?>
	  <div class="clear"></div>
	</div>
</div>

<?php }else{ ?>

<div class="box-content">
	<h2>Produto em falta!</h2>
	<?php 
		if(isset($_POST['atualizar'])){
			$quantidade_total = $_POST['quantidade_total'];
			$quantidade = $_POST['quantidade'];
			$produto_id = $_POST['produto_id'];
			$pega_dados = \MySQL::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
		    $pega_dados->execute(array($produto_id));
		    $dados = $pega_dados->fetch();
    		$qtd_cartoon = $dados['quantidade'];
    		$cartoons = 0;
			for ($i=0; $i <= $quantidade; $i+=$qtd_cartoon) { 
				if ($i <= $quantidade) {
					$cartoons++;  
				} 		      
			}
			if($quantidade < 0){
				Painel::alert('erro','Você não pode cadastra quantidade para igual ou menor a 0!');
			}else{
				
				MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade_total = $quantidade_total WHERE id = $produto_id");
			Painel::alert('sucesso','Você atualizou a quantidade do produto. Para ver a Lista clique <a href="'.INCLUDE_PATH_PAINEL.'visualizar-produtos">aqui</a>');
			}
		}
		echo '<br>';
		Painel::alert('atencao', 'Todos os produtos listados a baixo estão em falta no seu estoque');
		
	 ?>
	<div class="boxes">
		<?php 
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade_total = 0");
			$sql->execute();
			$produtos = $sql->fetchAll();
			foreach ($produtos as $key => $value) {
				$imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
				$imagemSingle->execute();
				$imagemSingle = $imagemSingle->fetch()['imagem'];
				$categoriaInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.categorias` WHERE id = ?");
				$categoriaInfo->execute(array($value['categoria_id']));
				$categoria = $categoriaInfo->fetch();
				$subcategoriaInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.subcategoria` WHERE id = ?");
				$subcategoriaInfo->execute(array($value['subcategoria_id']));
				$subcategoria = $subcategoriaInfo->fetch();
				$fornecedorInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.fornecedor` WHERE id = ?");
				$fornecedorInfo->execute(array($value['fornecedor_id']));
				$fornecedor = $fornecedorInfo->fetch();

				
		 ?>
		<div class="box-single-wraper">
			<div style="padding:8px 15px;height: 100%;">
				<div style="width: 100%;float: left;" class="box-imagem">
					<?php 
						if($imagemSingle == ''){
					?>
						<h1><i class="fas fa-shopping-basket"></i></h1>
					<?php
						}else{
					 ?>
				<img class="img-produto" src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $imagemSingle; ?>" />
				<?php } ?>
			</div>
			<div class="box-single">
			<div class="body-box">
				<p><b>Nome do Produto:</b> <?php echo $value['nome']; ?></p>
				<p><b>Código:</b><?php echo $value['codigo']; ?></p>
				<p><b>Categoria: </b><?php echo $categoria['nome']; ?></p>
				<p><b>SubCategoria: </b><?php echo $subcategoria['nome']; ?></p>
				<p><b>Fornecedor: </b> <?php echo $fornecedor['nome']; ?></p>
				<p><b>Preço: </b>R$ <?php echo Painel::convertMoney($value['preco']); ?></p>
				<p><b>Preço: </b>R$ <?php echo Painel::convertMoney($value['preco']); ?></p>
				<p><b>Preço Atacado: </b>R$ <?php echo Painel::convertMoney($value['preco_atacado']); ?></p>
				<p><b>Cartoon: </b><?php echo $value['cartoons']; ?></p>
				<div class="group-btn" style="border-bottom: 1px solid #ccc;">
					<form method="post">
						<label>Quantidade atual: </label>
						<input type="number" name="quantidade_total" min="0" max="900" step="1" value="<?php echo $value['quantidade_total']; ?>">
						<input type="hidden" name="quantidade" value="<?php echo $value['quantidade']; ?>">
						<input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">

						<input type="submit" name="atualizar" value="Atualizar!">
					</form>
				</div>
				<div class="group-btn">
					<a item_id="<?php echo $value['id']; ?>" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL;?>visualizar-produtos?deletar=<?php echo $value['id'];?>"><i class="fa fa-times"></i> Excluir</a>
					<a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-produto?id=<?php echo $value['id'] ?> "><i class="fas fa-pencil-alt"></i> Editar</a>
				</div>
			</div>
		</div>
			
		</div>
	  </div>
	  <?php } ?>
	  <div class="clear"></div>
	</div>

</div>
<?php } ?>