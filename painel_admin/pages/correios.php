
<?php

if(isset($_GET['pago'])){
        $sql = MySql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = 1 WHERE id = ?");
        $sql->execute(array($_GET['pago']));
        Painel::alert('sucesso','O pagamento foi quitado com sucesso!');
}
?>
<div class="lista">
<div class="lista-conteudo">
    <div class="titulo">
    Entregas Correios
    </div><!--Titulo-->
    <div class="lista-item">
     <div class="container-correios">
        <?php 
            $sql = MySql::conectar()->prepare("SELECT en.*,cp.rastreio, ci.nome cliente FROM `tb_admin.pedidos_envios` en INNER JOIN `tb_cliente.pedidos` cp ON cp.id = en.pedido_id LEFT JOIN `tb_cliente.informacoes` ci ON ci.id = cp.id_cliente WHERE status IN ('ENVIADO', 'PROBLEMAS NA ENTREGA') AND entregue = 0 AND (informacao LIKE '%aguardando retirada%' OR informacao LIKE '%carteiro%' OR informacao LIKE '%incorreto%') ORDER BY dataInformacao DESC");
            $sql->execute();
            $correios = $sql->fetchAll();
            foreach ($correios as $key => $value) {
               
        ?>
        <div class="detalhe-correios">
            <div class="titulo-correios">
            Pedido: <?php echo $value['pedido_id'];?>
            </div>
            <div class="rastreio-cliente">
            <p><?php echo $value['rastreio'];?></p>
            <p><?php echo $value['cliente'];?></p>
            </div>
            <div class="correios-obs">
            <p><?php echo Painel::formatarData($value['dataInformacao']); ?></p>
            <p class="info_correios">
            <?php echo $value['informacao']; ?>
            </p>
            </div>
            <div class="button-correios" >
                <div style="width:200px" class="botao_contato"  contato="<?php echo $value['pedido_id'];?>">
                    <?php if($value['contato'] == 1){ ?>
                        <div class="feito-contato"><button class="contato" > Feito Contato </button></div>
                    <?php }else{ ?>
                        <div class="fazer-contato "><button class="contato"> Fazer Contato </button></div>
                    <?php } ?>
                    </div>
                    
                <div class="rastrear"><button class="abrirmodal correios_botao" abrirmodal="correios" rastreio="<?php echo $value['rastreio'] ?>"> Rastrear </button></div>
                
            </div><!--Button-correios-->
            <?php if($value['contato'] == 1){ echo Painel::formatarDataHora($value['data_contato']);} ?>
        </div><!--Detalhe-correios--> 
        
        <?php } ?>
     </div><!--Container-correios--> 
     
    </div><!--Lista-item-->           
 </div><!--Lista-conteudo-->
</div><!--Lista-->

<div class="bg-modal" id="modal_correios">
        <div class="modal">
        <div class ="fecha-modal">
            <span class="close">&times;</span>
        </div>
        <div class="titulo">Rastreio </div>
            <div class="carregar">Carregando...</div>
            <div class="rastreio_correios"></div>
        </div>
    </div>