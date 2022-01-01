<div class="container">
    <div class="verification"> 
      <div class="logar">
        <h2 class="center">Nova senha</h2>
            <form action="" method="post">
                <?php
                if(isset($_GET['rash'])){
                 //$consumidor = new Consumido();
                 echo Consumido::verificaRash($_GET['rash']);
                }
                
                ?>
                <label for="">Nova Senha</label>
                <input class="form-login" type="password" name="senha" placeholder="Digita uma nova senha">
                
                <input type="submit" value="Alterar Senha" class="btn-login">
                <input type="hidden" name="env" value="upd">

            </form>
      </div>
    </div>
</div>