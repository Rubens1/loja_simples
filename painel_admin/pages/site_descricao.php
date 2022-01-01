<?php
	verificaPermissaoPaginaColaborado(2);
?>
<div class="container">
	<div class="row">
		<div class="bg-light my-4 col-12 text-center">
			<h1 class="disolay-4"><i class="fas fa-users"></i> Sobre a empresa</h1>
		</div>
		
	</div>
	<div class="row justify-content-center mb-5">



			<div class=" bg-light col-sm-9 col-md-9 col-lg-9">
				<form class="form-row mt-4 ajax" method="post" enctype="multipart/form-data">

			<?php
			if(isset($_POST['acao'])){
			
				if(Painel::insert($_POST)){
					Painel::alert('sucesso','O cadastro do depoimento foi realizado com sucesso!');
				}else{
					Painel::alert('erro','Campos vázios não são permitidos!');
				}
			

			}
		?>

				<div class="form-group col-sm-12">
					<label>Descricão da empresa: </label>
					<input type="text" class="form-control" name="descricao">
				</div>
				<div class="form-group col-sm-12">
					<input type="hidden" name="order_id" value="0">
					<input type="hidden" name="nome_tabela" value="tb_site.descricao" />
					<input class="btn btn-info" type="submit" name="acao" value="Cadastra">
				</div>
				</form>
		</div>	
	</div>
	<div class="clear"></div>
</div>