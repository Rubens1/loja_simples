<div class="pedidos-container">

<div class="form-busca">

            <form action="" method="post">
            <div class="titulo">Pedidos</div>
               <input type="text" name="cadastro" placeholder="Numero do Pedido">
                <button class="botao-azul">Busca</button>
            </form>
        </div><!--Form-busca-->
        
        <div class="pedidos">
            <div class="conteiner_pedidos">
                <div class="filter_pedidos">
                    <div class="data">
                        <?php 
                        $datas = MySql::conectar()->prepare("SELECT date(criado) dataPagamento, COUNT(date(criado)) quantidade FROM `tb_cliente.pedidos` 
                                                            WHERE status  = 0 
                                                            AND status_interno = '' 
                                                            GROUP BY date(criado) ORDER BY criado ASC");
                        $datas->execute();
                        $datas = $datas->fetchAll();
                        
                        foreach($datas as $key => $data){
                            if($data['quantidade'] >= 1){
                                $dia = $data['dataPagamento'];
                                //$dia = date('Y-m-d H:i:s', strtotime('-2 days', strtotime($data['dataPagamento'])));
                        ?>
                                <div class="data_dia" data_dia="<?php echo $data['dataPagamento'];?>" >
                                    <?php echo Painel::formatarData($dia);?> <span><?php echo $data['quantidade'] ?></span>
                                </div><!--Data_dia-->
                        <?php } } ?>
                    
                    </div><!--Data-->
                </div><!--Filter_pedidos-->
                
                <div class="pedidos_lista">
                <div class="conteudo_tipos">
                <div class="tipo"></div>
                    <div class="imprecao_multiplo">
                        <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>" target="_blank" class="imprima_todos">IMPRIMIR TODOS</a>
                    </div><!--Imprecao_multiplo-->
                </div><!--Conteudo_tipos-->
                <div class="pedidos_lista">
                    <div class="titulo_pedido">
                        <div class="coluna_info_pedido">Código do Pedido</div><!--Coluna_info_pedido-->
                        <div class="coluna_info_pedido">Status</div><!--Coluna_info_pedido-->
                        <div class="coluna_info_pedido">Frete</div><!--Coluna_info_pedido-->
                        <div class="coluna_info_pedido">Data</div><!--Coluna_info_pedido-->
                        <div class="coluna_info_pedido">Ações</div><!--Coluna_info_pedido-->
                    </div><!--Titulo_pedido-->
                    <div id="pedido_do_dia">
                        
                    </div><!--pedido_do_dia-->  
                           
                </div><!--Pedidos_lista-->
            </div><!--Conteiner_pedidos-->
        </div><!--Pedidos-->
    </div><!--Pedidos-container-->

    <div class="bg-modal" id="modal_cliente">
        <div class="modal">
        <div class ="fecha-modal">
            <span class="close">&times;</span>
        </div>
        <div class="titulo">Mais Detalhes </div>
        <div class="carregar">Carregando...</div>
            <div class="user_pedido"></div>
        </div>
    </div>
    <div class="bg-modal" id="modal_produtos">
        <div class="modal">
        <div class ="fecha-modal">
            <span class="close">&times;</span>
        </div>
        <div class="titulo">Lista de produtos </div>
        <div class="carregar">Carregando...</div>
            <div class="produtos_pedido"></div>
            <div class="botao-grupo">
                <input class="btn botao-azul" id="finalizar" type="submit" name="acao" value="Finalizar">
            </div>
            <div class="produto_verificado"></div>
        </div>
    </div>
    <div class="bg-modal" id="modal_observacao">
        <div class="modal">
        <div class ="fecha-modal">
            <span class="close">&times;</span>
        </div>
        <div class="titulo">Observação</div>
        <div class="obs_pedido"></div>
        <div class="pedidos">
            
            <div class="conteiner_pedidos">
            <form method="post" id="formulario_obs">
                <textarea name="obs" id="obs_text" class="modal_textarea"></textarea>
                <input type="hidden" id="obs_idproduto">
                <div class="botao-grupo">
                    <input class="btn botao-azul" id="obs_botao" type="submit" name="acao" value="Envia">
                </div><!--botao-grupo-->
            </form>
            </div><!--Container_pedidos-->
        </div><!--Pedidos-->
        </div>
    </div>