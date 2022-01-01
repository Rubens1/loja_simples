<?php 
	if(isset($_GET['deletarImagem'])){
		$idImagem = $_GET['deletarImagem'];
		@unlink(BASE_DIR_PAINEL.'/uploads/'.$idImagem);
		MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE imagem = '$idImagem'");
		
	}

	$id = (int)$_GET['id'];
	$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
	$sql->execute(array($id));
	if($sql->rowCount() == 0){
		Painel::alert('erro','O produto que você quer editar não existe!');
		die();
	}
	$infoProduto = $sql->fetch();
?>
<div class="produto_containe">
	<div class="produto_box">
		<div class="titulo_produto">
			<h1>Editar Produto: <?php echo $infoProduto['nome']; ?></h1>
		</div><!-- Titulo Produto -->

		<?php
			$pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
			$pegaImagens->execute();
			$pegaImagens = $pegaImagens->fetchAll();
		if(isset($_GET['deletarImagem'])){
				Painel::alert('sucesso','A imagem foi deletada com sucesso!');
			}
		?>
		
		<form method="post" action="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>editar_produto?id=<?php echo $id;?>" enctype="multipart/form-data" class="form-editar">
		<?php 
			if(isset($_POST['acao'])){
				$nome = $_POST['nome'];
				$largura = $_POST['largura'];
				$altura = $_POST['altura'];
				$comprimento = $_POST['comprimento'];
				$peso = $_POST['peso'];
				$quantidade = $_POST['quantidade'];
				$preco = Painel::formatarMoedaBd($_POST['preco']);
				$preco_venda = Painel::formatarMoedaBd($_POST['preco_venda']);
				$id_categoria = $_POST['id_categoria'];
				$id_subcategoria = $_POST['id_subcategoria'];
				$video = $_POST['video'];
				$descricao = $_POST['descricao'];
				$custo = Painel::formatarMoedaBd($_POST['custo']);
				$imagens = [];

				$sucesso = true;
				
				$amountFiles = count($_FILES['imagem']['name']);
				
				if($_FILES['imagem']['name'][0] != ''){
					for($i = 0; $i < $amountFiles; $i++){
					$imagemAtual = ['type'=>$_FILES['imagem']['type'][$i], 'size'=>$_FILES['imagem']['size'][$i]];
					if(Painel::imagemValida($imagemAtual) == false){
						$sucesso = false;
						Painel::alert('erro','Uma das imagem selecionadas são invalidas!');
						break;
						}
					}
				}

				if($sucesso){
					if($_FILES['imagem']['name'][0] != ''){
					for($i = 0; $i < $amountFiles; $i++){
						$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i], 'name'=>$_FILES['imagem']['name'][$i]];
					$imagens[] = Painel::uploadFileProduto($imagemAtual);
					}

					foreach($imagens as $key => $value){
						MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$id,'$value')");
						}
					}

					$sql = MySql::conectar()->prepare("UPDATE `tb_admin.estoque` SET  nome = ?, video = ?, altura = ?, largura = ?, comprimento = ?, peso = ?, quantidade = ?, preco = ?,preco_venda = ?, custo = ?, id_categoria = ?,id_subcategoria = ?, descricao = ? WHERE id = $id");
					$sql->execute(array($nome,$video,$altura,$largura,$comprimento,$peso,$quantidade,$preco, $preco_venda, $custo, $id_categoria,$id_subcategoria,$descricao));

					Painel::alert('sucesso','Você atualizou seu produto com sucesso!');
					$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
					$sql->execute(array($id));

					$infoProduto = $sql->fetch();
					$pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
					$pegaImagens->execute();
					$pegaImagens = $pegaImagens->fetchAll();
				}
			}
		 ?>

				<div class="area_um">
					<div class="form-group">
						<label>Nome do produto:</label>
						<input class="form-control" type="text" name="nome" value="<?php echo $infoProduto['nome']; ?>">
					</div><!--form-group-->
				</div><!--Area_um-->
				<div class="area_dois">
					<div class="form-group">
						<label>Categoria:</label>
						<select class="form-control" name="id_categoria">
							<?php
							$slide = Painel::select('tb_admin.estoque','id = ?',array($id));
								$categorias = Painel::selectAll('tb_admin.categorias');
								foreach ($categorias as $key => $value) {
							?>
							<option <?php if($value['id'] == $slide['id_categoria']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['id']," - ", $value['nome']; ?></option>
							<?php } ?>
						</select>
					</div><!--form-group-->
					<div class="form-group">
						<label>Subategoria:</label>
						<select class="form-control subcategoria" name="id_subcategoria">
							<?php
							$slide = Painel::select('tb_admin.estoque','id = ?',array($id));
								$subcategorias = Painel::selectAll('tb_admin.subcategoria');
								foreach ($subcategorias as $key => $value) {
									if($slide['id_categoria'] == $value['categoria_id']	){
							?>
							<option <?php if($value['id'] == $slide['id_subcategoria']) echo 'selected'; ?> value="<?php echo $value['id'] ?>"><?php echo $value['id']," - ", $value['nome']; ?></option>
							<?php } } ?>
							<option value="">Sem uma Subcategoria</option>
						</select>
					</div><!--form-group-->
				</div><!--Area_dois-->
				<div class="area_tres">
					<div class="form-group ">
						<label>Video do produto: </label>
						<input type="text" class="form-control" name="video" value="<?php echo $infoProduto['video']; ?>">
					</div><!--form-group-->
				</div><!--Area_tres-->
				<div class="area_quatro">
					<div class="form-group ">
						<label>Descrição: </label>
						<textarea name="descricao" value=""><?php echo $infoProduto['descricao']; ?></textarea>
					</div><!--form-group-->
				</div><!--Area_quatro-->
				<div class="area_cinco">
					<div class="form-group ">
						<label>Largura do produto: </label>
						<input type="text" class="form-control" name="largura" value="<?php echo $infoProduto['largura']; ?>">
					</div><!--form-group-->
					<div class="form-group ">
						<label>Altura do produto: </label>
						<input type="text" class="form-control" name="altura" value="<?php echo $infoProduto['altura']; ?>">
					</div><!--form-group-->
					<div class="form-group ">
						<label>Comprimento do produto: </label>
						<input type="text" class="form-control" name="comprimento" value="<?php echo $infoProduto['comprimento']; ?>">
					</div><!--form-group-->
					<div class="form-group ">
						<label>Peso do produto: </label>
						<input type="text" class="form-control" name="peso" value="<?php echo $infoProduto['peso']; ?>">
					</div><!--form-group-->
				</div><!--Area_cinco-->
				<div class="area_seis">
					<div class="form-group ">
						<label>Quantidade atual do produto: </label>
						<input type="text" class="form-control" name="quantidade" value="<?php echo $infoProduto['quantidade']; ?>">
					</div><!--form-group-->
					
					<div class="form-group ">
						<label>Preço: </label>
						<input type="text" class="form-control" name="preco" value="<?php echo Painel::convertMoney($infoProduto['preco']); ?>">
					</div><!--form-group-->
					<div class="form-group">
						<label>Preço de venda:</label>
						<input class="form-control" type="text" name="preco_venda" value="<?php echo Painel::convertMoney($infoProduto['preco_venda']); ?>">
					</div><!--form-group-->
					<div class="form-group">
						<label>Preço de Custo:</label>
						<input class="form-control" type="text" name="custo"value="<?php echo Painel::convertMoney($infoProduto['custo']); ?>">
					</div><!--form-group-->
				</div><!--Area_seis-->
				<div class="form-group ">
					<label>Selecione uma Imagem: </label>
					<input multiple type="file" class="form-control" name="imagem[]">
				</div><!--form-group-->
			
				<div class="botao-grupo">
					<input class="botao botao-verde " type="submit" name="acao" value="Atualizar Produto">
				</div><!--botao-grupo-->
			</form>
			<?php /*
			<div class="card-title"><i class="fas fa-project-diagram"></i> Variantes</div>
				<form action="" method="post">
					<div class="form-editar">
						<div class="form-group ">
						<label>Variante </label>
							<input type="text" class="form-control" name="nome">
						</div><!--form-group-->
						<div class="form-group ">
							<label>Selecione uma Imagem: </label>
							<input multiple type="file" class="form-control" name="referenca">
						</div><!--form-group-->
					</div><!--form-editar-->
					<div class="botao-grupo">
						<input class="botao botao-verde " type="submit" name="variante" value="Adicionar Variante">
						<div class="add_variante">
							<i class="far fa-plus-square"></i>
						</div><!--add_variante-->
					</div><!--botao-grupo-->
				</form>
			 */ ?>
			<div class="card-title"><i class="fas fa-edit"></i> Imagens do produto</div>
			<div class="produto_card">
			<?php foreach ($pegaImagens as $key => $value){ ?>
				<div class="container_produto">
					<div class="img_produto">
						<img class="img-produto"  src="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>produtos/<?php echo $value['imagem']; ?>" />
					</div><!-- Img_Produto -->
					<div class="detalhe_produto">
						<div style="margin-left:25px" class="botao_produtos">
							<a class="botao botao-vermelho" href="<?php echo INCLUDE_PATH_PAINEL_ADMIN?>editar_produto?id=<?php echo $id; ?>&deletarImagem=<?php echo $value['imagem']; ?>"><i class="fa fa-times"></i> Excluir</a>
						</div><!-- Botao_Produtos -->
					</div><!-- Detalhe_Produto -->
				</div><!-- Container_Produto -->

				<?php } ?>
			</div><!-- produto_card -->
	</div><!--Produto_box -->
</div><!--pProduto_containe -->