<div class="lista">
    <div class="conteiner_painel">
        <div class="painel_lista">
            <div class="titulo">
                Sem Código
            </div><!--Titulo-->
        </div>
        <div class="painel_lista">
            <div class="titulo_painel">
                    <div class="coluna_info_painel">Pedido</div><!--coluna_info_painel-->
                    <div class="coluna_info_painel">Cliente</div><!--coluna_info_painel-->
                    <div class="coluna_info_painel">Rastreio</div><!--coluna_info_painel-->
            </div><!--Titulo_pedido-->
                <?php
                    $sql = MySql::conectar()->prepare("SELECT cp.id,cp.id_cliente, ci.nome,cp.rastreio,cp.status FROM `tb_cliente.pedidos` cp INNER JOIN `tb_cliente.informacoes` ci ON ci.id = cp.id_cliente WHERE rastreio IN ('', null) and status = 'ENVIADO' ORDER BY id limit 10 ");
                    $sql->execute();
                    $rastreio = $sql->fetchAll();
                    foreach ($rastreio as $key => $value) {
                ?>
            <div class="info_painel">
                <div class="coluna_info_painel"><?php echo $value['id'];?></div><!--coluna_info_painel-->
                <div class="coluna_info_painel"><?php echo $value['nome'];?></div><!--coluna_info_painel-->
                <div class="coluna_info_painel">
                    <form method="post" class="rastreio-form form_rastreio" rastreio_id="<?php echo $value['id'];?>">
                        <input type="text" class="codigo_rastreio_<?php echo $value['id'];?>" placeholder="coloque o rastreio aqui" value="">
                        <button class="btn botao-verde" >Salvar</button>
                        <div class="resultado_envio"></div>
                    </form>
                </div><!--coluna_info_painel-->
            </div><!--Info_painel-->
            <?php } ?>
        </div><!--Painel_lista-->
     </div><!--conteiner_painel-->
</div><!--Lista-->