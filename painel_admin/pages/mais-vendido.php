<?php 
if(isset($_POST['acao'])){
    $tipo = $_POST['tipo'];
    $data1 = $_POST['de']. " 00:00:00";
    $data2 = $_POST['ate']. " 23:59:59";

    if(!isset($_POST['de'], $_POST['ate']) && empty($_POST['de']) && empty($_POST['ate'])){
        $data1 = date('Y-m', strtotime('-3 month', time())) . '-01';
        $data2 = date('Y-m-d') . " 23:59:59";
    }
}

?>
<div class="lista">
    <div class="conteiner_painel">
        <div class="painel_lista">
            <div class="titulo">
                Os mais vendas
            </div><!--Titulo-->
            <form action="" method="post" class="form-busca">
                <label> De: </label>
                <input type="date" name="de">
                <label> Até: </label>
                <input type="date" name="ate">

                <select name="tipo" class="select">
                    <option value="tipo">Selecione o tipo</option>
                    <option value="papel">Papel de Parede</option>
                    <option value="placa">Placas</option>
                    <option value="adesivo">Adesivos</option>
                    <option value="espelho">Espelhos</option>
                    <option value="azulejo">Azulejo</option>
                </select>
                <button class="btn botao-azul" type="submit" name="acao">Busca</button>
            </form>
        </div><!--Painel_lista-->
        <div class="rank-vendas">
            <div class="painel_lista">
                
                <div class="data_rank"><?php if(isset($_POST['acao'])){ echo 'De: '. Painel::formatarData($data1).' Até: '. Painel::formatarData($data2); }?></div>
                <div class="titulo_painel">
                        <div class="coluna_info_painel">Rank</div><!--coluna_info_painel-->
                        <div class="coluna_info_painel">Nome</div><!--coluna_info_painel-->
                        <div class="coluna_info_painel">Quantidade</div><!--coluna_info_painel-->
                    </div><!--Titulo_pedido-->
                    <?php  
                    
                        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque`");
                
                        $sql->execute();
                        $rank = $sql->fetchAll();                                       
                            foreach($rank as $key => $value){
                                
                                for($i = 0; $i <= $key;$i++){
                                    $numero = $i + 1;
                                } 
                                    
                                    ?>
                    <div class="info_painel">
                        <div class="coluna_info_painel"><?php 
                        if( $numero == 1){ ?>
                            <img width="30" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/rank1.png" alt="">
                        <?php
                        }else if($numero == 2){?>
                            <img width="30" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/rank2.png" alt="">
                        <?php }else if($numero == 3){ ?>
                            <img width="30" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/rank3.png" alt="">
                        <?php }else{
                            echo $numero.'º';
                        }
                        ?></div><!--coluna_info_painel-->
                        <div class="coluna_info_painel"><p style="font-weight: normal;"><?php echo $value['nome'];?></p></div><!--coluna_info_painel-->
                        <div class="coluna_info_painel"><?php echo $value['vendido']; ?></div><!--coluna_info_painel-->
                    </div><!--info_painel-->  
                    <?php } ?>
                </div><!--Painel_lista-->
            </div><!--Painel_lista-->
        </div><!--Rank-vendas-->
    </div><!--Conteiner_painel-->
</div><!--Lista-->
