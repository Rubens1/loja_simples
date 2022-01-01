<div class="container-login">
    <div class="verification-cadastro">
    <div class="cadastrar">
            <form method="post">
                <div class="titulo-cadastro"> <h1>Cadastre aqui</h1></div>
                        <?php 
                        if(isset($_POST['acao'])){
                            
                            $nome = $_POST['nome'];
                            $sobrenome = $_POST['sobrenome'];
                            $email = $_POST['email'];
                            $cpf = ''; //$_POST['cpf'];
                            $senha_sem_cript = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
                            $senha = password_hash($senha_sem_cript,PASSWORD_DEFAULT);
                            $confirmasenha = filter_input(INPUT_POST, 'confirmasenha', FILTER_DEFAULT);
                            
                            if(Consumido::consumidoExists($email)){
                                Painel::alert('erro',' O email já existe, selecione outro por favor!');
                            }else{
                                //Apenas cadastrar no banco de dado//
                                Consumido::cadastrarConsumido($nome,$sobrenome,$email,$cpf,$senha);
                                echo Painel::alertJS('O cadastro foi feito com sucesso');
                                $email = $_POST['email'];
                                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.informacoes` WHERE email = ?");
                                $sql->execute(array($email));
                                $info = $sql->fetch();
                                    $_SESSION['consumido'] = true;
                                    $_SESSION['email'] = $email;
                                    $_SESSION['senha'] = $senha;
                                    $_SESSION['id_usuario'] = $info['id'];
                                    $_SESSION['nome'] = $info['nome'];
                                    echo Painel::redirect(INCLUDE_PATH);
                                    die();
                                
                                }
                            }
                        ?>
                <div class="cadastro">
                    <div class="cadastro-cliente">
                        <div class="info-cadastro">                            
                            <label>Nome</label>
                            <input class="form-cadastro" type="text" name="nome" required>
                        </div><!--Info-cadastro -->
                        <div class="info-cadastro">
                            <label>Sobrenome</label>
                            <input class="form-cadastro" type="text" name="sobrenome" required>
                        </div><!--Info-cadastro -->
                        <div class="info-cadastro">
                            <label>Email</label>
                            <input class="form-cadastro" type="email" name="email" required>
                        </div><!--Info-cadastro -->
                        <div class="info-cadastro">
                            <label>Senha</label>
                            <input class="form-cadastro" type="password" name="senha" required>
                        </div><!--Info-cadastro -->
                    </div><!--Cadastro-cliente -->
                    
                </div><!--Cadastro -->
                <div class="center">
                    <input type="submit" value="registra" name="acao" class="btn-cadastro">
                </div><!--Center -->
            </form>

        </div><!-- Cadastrar -->
    </div><!-- Verification-cadastro -->
</div><!-- Container-login -->