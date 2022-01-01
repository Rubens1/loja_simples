<?php
	verificaPermissaoPaginaADM(2);
?>
<div class="perfil-parent">
    <div class="perfil">
        <div class="perfil-img">
            <div class="img-colaborado">
                <img class="img" src="" alt="">    
            </div>
        </div>
        <div class="perfil-form">
           
            <form method="post" enctype="multipart/form-data">

					
					<?php 
					if(isset($_POST['acao'])){
						$login = $_POST['login'];
						$nome = $_POST['nome'];
						$senha = $_POST['password'];
						$imagem = $_FILES['imagem'];
						$cargo = $_POST['cargo'];
						

						if($login == ''){
							Painel::alert('erro','O login está vázio!');
						}else if($nome == ''){
							Painel::alert('erro','O nome está vázio!');
						}else if($senha == ''){
							Painel::alert('erro','O senha está vázio!');
						}else if($email == ''){
							Painel::alert('erro','O email está vázio!');
						}else if($cargo == ''){
							Painel::alert('erro','Você tem que escolher um cargo!');
						}else if(Painel::imagemValida($imagem) == false){
							Painel::alert('erro','O formato especificado não está correto!');
						}else{
							if($cargo >= $_SESSION['cargo']){
						Painel::alert('erro','Você precisa selecionar um cargo menor que o seu!');
						}else if(Usuario::userExists($login)){
						Painel::alert('erro','O login já existe, selecione outro por favor!');
						}else{
								//Apenas cadastrar no banco de dado//
								$usuario = new Usuario();
								$imagem = Painel::uploadPerfil($imagem);
								$usuario->cadastrarUsuario($login,$senha,$nome,$imagem,$cargo);
								Painel::alert('sucesso','O cadastro foi feito com sucesso!');
							}
						}
					} 
					?>
<div class="form-group-add">
					<label>Nome</label>
					<input class="form-control" type="text" name="nome">
				</div><!--form-group-add-->
				<div class="form-group-add">
					<label>Usuário</label>
					<input class="form-control" type="text" name="user">
				</div><!--form-group-add-->
				<div class="form-group-add">
					<label>Senha</label>
					<input class="form-control" type="password" name="senha">
				</div><!--form-group-add-->
				<div class="form-group-add">
					<label>Cargo</label>
					<select class="form-control" name="cargo">
						<?php
							foreach (Painel::$cargos as $key => $value) {
								if($key < $_SESSION['cargo']) echo '<option value="'.$key.'">'.$value.'</option>';
							}
						?>
					</select>
				</div><!--form-group-add-->
				<div class="form-group-add">
					<label>Foto do Colaborado</label>
					<input class="form-control" type="file" name="imagem" id="imagem" onchange="previewImagem()">
				</div> <!--form-group-add-->
					<input class="btn botao-verde" type="submit" name="acao" value="Cadastrar">
			</form>
            
			</div><!--Perfil-form-->
    </div><!--Perfil-->
</div><!--Perfil-parent-->
	
	
