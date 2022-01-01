<?php
			if(isset($_POST['acao'])){
				//Enviei o meu formulário.
                $senha_sem_cript = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
                $senha = password_hash($senha_sem_cript,PASSWORD_DEFAULT);
                $confirma_senha = filter_input(INPUT_POST, 'confirma_senha', FILTER_DEFAULT);
                if($confirma_senha == $senha_sem_cript){
					Usuario::atualizarSenha($senha);
						Painel::alert('sucesso','Senha atualizada com sucesso!');
                }else{
                    Painel::alert('erro','Ocorreu um erro ao atualizar...');
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
                <a class="senha-colaborado" href="<?php echo INCLUDE_PATH_PAINEL_ADMIN?>editar_usuario">Editar perfil</a>
                
            </div>
            <form method="post" enctype="multipart/form-data">
                
                <div class="form-group-add">
                    <label for="senha">Senha Atual</label>
                    <input class="form-control" type="password" name="senha" require>
                </div>
                <div class="form-group-add">
                    <label for="confirma_senha">Confirma Senha</label>
                    <input class="form-control" type="password" name="confirma_senha" require>
                </div>
                
                <button type="submit" name="acao" class="btn botao-azul">Salvar</button>
            
            </form>
            
        </div>
    </div>
</div>