
<?php
    if(isset($_POST['busca'])){
        $data1 = $_POST['de'];
        $data2 = $_POST['ate'];
        
    }else{
        $x = date('d') -1;
        $data1 =  Painel::formatarDataUS("-$x days"). " 00:00:00";
        $data2 = date("Y-m-d") . " 23:59:59";
    }

    
    if(isset($_POST['limpa'])){
        unset( $_POST['de']);
        unset( $_POST['ate']);
    }
    $contabilidade = Contabilidade::lista($data1,$data2);
?>
<div class="lista">
    <div class="conteiner_painel">
        <div class="painel_lista">
            <div class="titulo">
                Contabilidade
            </div><!--Titulo-->
            <div class="botao_contabilidade">
                <div class="btn botao-verde abrirmodal" abrirmodal="filtrar">Filtrar</div>
                <form class="limpa_form" method="post">
                    <button class="btn botao-vermelho" name="limpa">Limpar Filtros</button>
                </form>
                <div class="btn botao-amarelo contabilidade_atualizar">Atualizar</div>
                <div class="btn botao-cinza abrirmodal add_conta" abrirmodal="conta">Adicionar conta</div>
            
            </div><!--Botao_contabilidade-->
        </div>
            <div class="painel_lista">
                <div class="titulo_contabilidade">
                    <div class="coluna_info_painel">Data</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                        <div class="coluna_info_painel"><?php echo Painel::formatarData($value['data']); ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Titulo_contabilidade-->
                 <div class="info_contabilidade">
                    <div class="coluna_info_painel">Pedidos</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                        <div class="coluna_info_painel"><?php echo $value['pedidos']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Vendas</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                        <div class="coluna_info_painel"><?php echo $value['vendas']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Faturamento</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                        <div class="coluna_info_painel">R$ <?php echo $value['faturamento']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Ticket Medio</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                        <div class="coluna_info_painel">R$ <?php echo $value['ticket_medio']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade contabilidade_produto">
                    <div class="coluna_info_painel">Produto</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                         <div class="coluna_info_painel">R$ <?php echo $value['produto']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Imposto</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                         <div class="coluna_info_painel">R$ <?php echo $value['imposto']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Funcionarios</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                         <div class="coluna_info_painel">R$ <?php echo $value['funcionarios']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Fixos</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                         <div class="coluna_info_painel">R$ <?php echo $value['fixos']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Publicidade</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) { ?>
                         <div class="coluna_info_painel abrirmodal publicidade_click" abrirmodal="publicidade" publicidade="<?php echo $key; ?>" rota="contabilidade">R$ <?php echo $value['publicidade']; ?></div><!--coluna_info_painel-->
                    <?php } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Total</div><!--coluna_info_painel-->
                    <?php foreach ($contabilidade as $key => $value) {
                        if($value['total'] > 0){ ?>
                         <div class="coluna_info_painel">R$ <?php echo $value['total']; ?></div><!--coluna_info_painel-->
                        <?php }else{ ?>
                            <div class="coluna_info_painel">R$ 0,00</div><!--coluna_info_painel-->
                        <?php } } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">Lucro</div><!--coluna_info_painel-->
                    <?php 
                        foreach ($contabilidade as $key => $value) {
                            if($value['lucro'] < 0){
                     ?>
                      <div class="coluna_info_painel perda">R$ <?php echo $value['lucro']; ?></div><!--coluna_info_painel-->
                     <?php }else if($value['lucro'] > 0){?>
                        <div class="coluna_info_painel ganho">R$ <?php echo $value['lucro']; ?></div><!--coluna_info_painel-->
                    <?php }else{ ?>
                        <div class="coluna_info_painel">R$ 0,00</div><!--coluna_info_painel-->
                     <?php } } ?>
                </div><!--Info_contabilidade-->
                <div class="info_contabilidade">
                    <div class="coluna_info_painel">%Produto</div><!--coluna_info_painel-->  
                    <?php foreach ($contabilidade as $key => $value) { 
                        if($value['%produto'] == ''){ ?>
                         <div class="coluna_info_painel">0%</div><!--coluna_info_painel-->
                    <?php }else{ ?>
                        <div class="coluna_info_painel"><?php echo $value['%produto']; ?></div><!--coluna_info_painel-->
                    <?php } } ?> 
                </div><!--Info_painel-->
            </div><!--Painel_lista-->
    </div><!--Conteiner_painel-->
</div><!--Lista-->
