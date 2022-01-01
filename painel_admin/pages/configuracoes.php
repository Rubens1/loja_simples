<div class="configuracao-container">
    <div class="configuracao">
        <div class="titulo">Configuração</div>
            <div class="btn-configuracao">
                <button class="btn botao-azul">Criar alerta</button>
            </div><!--Btn-configuracao-->
            <?php
                 $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.configuracoes`");
                 $sql->execute();
                 $solicitado = $sql->fetchAll();
                 foreach ($solicitado as $key => $value) { 
            ?>
            <div class="form-configuracao">
                <h2><?php echo ucfirst($value['tipo']);?></h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Info. Brinde</label>
                        <input type="text" placeholder="<?php echo $value['conteudo'];?>">
                    </div>
                    <div class="form-group">
                        <label for="">A partir do Pedido</label>
                        <input type="number" placeholder="<?php echo $value['id_inicial'];?>">
                    </div>
                    <div class="form-group">
                        <label for="">Até o Pedidos</label>
                        <input type="number" placeholder="<?php echo $value['id_final'];?>">
                    </div>
                    <div class="form-group">
                        <label for="">A partir do Valor</label>
                        <input type="text" name="valor" placeholder="R$ <?php echo Painel::convertMoney($value['valor']);?>">
                    </div>
                    <div class="form-group">
                        <label for="">Ativo</label>
                        <select name="ativo">
                            <option value="0">sim</option>
                            <option value="1">não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tipo</label>
                        <select name="tipo">
                        <option value="<?php echo $value2['tipo']?>"><?php echo ucfirst($value['tipo']);?></option>
                            <?php
                                foreach ($solicitado as $key => $value2) { 
                                    if($value['tipo'] != $value2['tipo']){
                            ?>
                            <option value="<?php echo $value2['tipo'];?>"><?php echo ucfirst($value2['tipo']);?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="form-group botton-form">
                        <button class="btn botao-verde">Salvar</button>
                        
                    </div>
                    <div class="form-group botton-form">
                        <button class="btn botao-vermelho"><i class="far fa-trash-alt"></i></button>
                    </div>
                </form>
            </div><!--configuracao-->
            <?php } ?>
        </div><!--configuracao-->
    </div><!--configuracao-container-->