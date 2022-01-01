<div class="produto_containe">
	<div class="produto_box">

	<h2><i class="fas fa-pen-square"></i> Cadastrar Produto</h2>


	<form method="post" enctype="multipart/form-data" class="form-cadastros">
		<?php
		if(isset($_POST['acao'])){

			$nome = $_POST['nome'];
			$codigo = $_POST['codigo'];
			$descricao = $_POST['descricao'];
			$largura = $_POST['largura'];
			$altura = $_POST['altura'];
			$peso = $_POST['peso'];
			$complimento = $_POST['complimento'];
			$quantidade = $_POST['quantidade'];
			$preco = Painel::formatarMoedaBd($_POST['preco']);
			$promocao =  Painel::formatarMoedaBd($_POST['promocao']);
			$custo =  Painel::formatarMoedaBd($_POST['custo']);
			$data_cadastro = date('Y-m-d');
			$categoria_id = $_POST['categoria_id'];
			//$subcategoria_id = $_POST['subcategoria_id'];
			$subcategoria_id = 0;
			$video = $_POST['video'];
			$total_vendido = 0;
			if($subcategoria_id == ''){
				$subcategoria_id = 0;
			}else{
				$subcategoria_id = $subcategoria_id;
			}
			$slug = Painel::generateSlug($nome);
			
			$imagens = array();
			$amountFiles = count($_FILES['imagem']['name']);

			$sucesso = true;

			if($_FILES['imagem']['name'][0] != ''){

			for($i =0; $i < $amountFiles; $i++){
				$imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
				'size'=>$_FILES['imagem']['size'][$i]];
				if(Painel::imagemValida($imagemAtual) == false){
					$sucesso = false;
					Painel::alert('erro','Uma das imagens selecionadas são inválidas!');
					break;
				}
			}

			}else{
				$sucesso = false;
				Painel::alert('erro','Você precisa selecionar pelo menos uma imagem!');
			}


			if($sucesso){
				//TODO: Cadastrar informacoes e imagens e realizar upload.
				for($i =0; $i < $amountFiles; $i++){
					$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
						'name'=>$_FILES['imagem']['name'][$i]];
					$imagens[] = Painel::uploadFileProduto($imagemAtual);
				}

				$sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.estoque` VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$sql->execute(array($categoria_id,$subcategoria_id,$nome,$codigo,$video,$descricao,$quantidade,$total_vendido,$preco,$promocao,$largura,$altura,$complimento,$peso,$custo,$data_cadastro,$slug));

				$lastId = MySql::conectar()->lastInsertId();
				foreach ($imagens as $key => $value) {
					MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$lastId,'$value')");
				}
				Painel::alert('sucesso','O produto foi cadastrado com sucesso!');
			}

			
		}

		?>
		<div class="area_um">
			<div class="form-group">
				<label>Nome do produto:</label>
				<input class="form-control" type="text" name="nome">
			</div><!--form-group-->

			<div class="form-group">
				<label>Codigo do poroduto:</label>
				<input class="form-control" type="text" name="codigo">
			</div><!--form-group-->
		</div><!--Area_um-->
		<div class="area_dois">
			<div class="form-group">
			<label>Categoria:</label>
			<select class="form-control" name="categoria_id" id="id_categoria">
			<option value="">Selecione a categoria</option>
				<?php
					$categorias = Painel::selectAll('tb_admin.categorias');
					foreach ($categorias as $key => $value) {
				?>
				<option class="categoria_id" item_categoria="<?php echo $value['id'] ?>" value="<?php echo $value['id'] ?>"><?php echo $value['nome']; ?></option>
				<?php } ?>
			</select>
			</div><!--form-group-->
		<!--<div class="form-group">
			<label>Subcategoria:</label>
				<select id="subcategoria_id" class="form-control subcategoria" name="subcategoria_id">
				</select>
			</div--><!--form-group-->
		</div><!--Area_dois-->
		<div class="area_tres">
			<div class="form-group">
				<label>Video:</label>
				<input class="form-control" type="text" name="video" >
			</div><!--form-group-->
		</div><!--Area_tres-->
		<div class="area_quatro">
			<div class="form-group">
				<label>Descrição:</label>
				<textarea name="descricao"></textarea>
			</div><!--form-group-->
		</div><!--Area_quatro-->
		<div class="area_cinco">
			<div class="form-group">
				<label>Largura do produto:</label>
				<input class="form-control" type="text" name="largura" >
			</div><!--form-group-->

			<div class="form-group">
				<label>Altura do produto:</label>
				<input class="form-control" type="text" name="altura" >
			</div><!--form-group-->

			<div class="form-group">
				<label>Complimento do produto:</label>
				<input class="form-control" type="text" name="complimento" >
			</div><!--form-group-->

			<div class="form-group">
				<label>Peso do produto:</label>
				<input class="form-control" type="text" name="peso" >
			</div><!--form-group-->
		</div><!--Area_cinco-->
		<div class="area_seis">
			<div ref="cartoons" class="form-group">
				<label>Quantidade:</label>
				<input class="form-control numeros" type="text" name="quantidade" >
			</div><!--form-group-->

			<div class="form-group">
				<label>Preço:</label>
				<input class="form-control" type="text" name="preco">
			</div><!--form-group-->

			<div class="form-group">
				<label>Preço de venda:</label>
				<input class="form-control" type="text" name="promocao">
			</div><!--form-group-->		
		<div class="form-group">
				<label>Preço de Custo:</label>
				<input class="form-control" type="text" name="custo">
			</div><!--form-group-->
		</div><!--Area_seis-->
		<div class="area_oito">
			<div class="form-group">
				<label>Selecione a capa do produto:</label>
				<input class="form-control" multiple type="file" name="imagem[]">
			</div><!--form-group-->
		</div>
			<div class="botao-grupo">
				<input class="btn botao-azul" type="submit" name="acao" value="Cadastrar">
			</div><!--botao-grupo-->
		
	</form>

	</div><!-- Produto Box -->
</div><!-- Produto Containe -->