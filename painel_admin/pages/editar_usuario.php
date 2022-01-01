<?php

			if(isset($_POST['acao'])){
				//Enviei o meu formulário.
				
				$nome = $_POST['nome'];
				$user = $_POST['user'];
				$imagem = $_FILES['imagem'];
				$imagem_atual = $_POST['imagem_atual'];
				if($imagem['name'] != ''){

					//Existe o upload de imagem.
					if(Painel::imagemValida($imagem)){
						Painel::deleteFile($imagem_atual);
						$imagem = Painel::uploadFile($imagem);
						if(Usuario::atualizarUsuario($nome,$imagem,$user)){
							$_SESSION['img'] = $imagem;
							Painel::alert('sucesso','Atualizado com sucesso junto com a imagem!');
						}else{
							Painel::alert('erro','Ocorreu um erro ao atualizar junto com a imagem');
						}
					}else{
						Painel::alert('erro','O formato da imagem não é válido');
					}
				}else{
					$imagem = $imagem_atual;
					if(Usuario::atualizarUsuario($nome,$imagem,$user)){
						Painel::alert('sucesso','Atualizado com sucesso!');
					}else{
						Painel::alert('erro','Ocorreu um erro ao atualizar...');
					}
				}

			}
		?>

<div class="perfil-parent">
    <div class="perfil">
        <div class="perfil-img">
            <div class="img-colaborado">
                <img class="img" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>/uploads/<?php echo $_SESSION['img']; ?>" alt="">    
            </div>
        </div>
        <div class="perfil-form">
            <div class="editar-info-colaborado">
                <a class="senha-colaborado" href="<?php echo INCLUDE_PATH_PAINEL_ADMIN?>editar_senha">Editar Senha</a>
                
            </div>
            <form method="post" enctype="multipart/form-data">
                
                <div class="form-group-add">
                    <label for="empresario">Nome</label>
                    <input class="form-control" type="text" name="nome" value="<?php echo $_SESSION['nome']; ?>">
                </div>
                <div class="form-group-add">
                    <label for="email">Usuario</label>
                    <input class="form-control" type="text" name="user" value="<?php echo $_SESSION['user']; ?>">
                </div>
				
                <div class="form-group-add">
				<label for="imagem">Foto</label>
                    <input class="form-control" type="file" name="imagem" id="imagem" onchange="previewImagem()">
                    
                    <input type="hidden" name="imagem_atual" value="<?php echo $_SESSION['img']; ?>">
                </div>
                
                <button type="submit" name="acao" class="btn botao-azul">Salvar</button>
            
            </form>
            
        </div>
    </div>
</div>