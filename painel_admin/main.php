<?php

  if(isset($_GET['loggout'])){
    Painel::admin_loggout();
  }

	?>
<!DOCTYPE html>
<html>
<head>
  <title>Painel de Controle</title>
  <meta charset="utf-8">   
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>font/css/all.css">
  <link href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>css/global.css" rel="stylesheet" />
  <link rel="shortcut icon" href="<?php echo INCLUDE_PATH; ?>img/ico/ico.ico" type="image/x-icon">
</head>
<body>
<base base="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>" />

<div class="flex-dashboard">
  <sidebar id="sidebar">
    <div class="logo-colando">
      <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>"><h1>LOGO</h1></a>
    </div>
    <div class="user-top">
        <div class="logo">
          <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>">
            <?php if($_SESSION['img'] == ''){
              ?>
              <i class="fas fa-user-circle"></i>
              
              <?php
            }else{ ?>
            <img src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>/uploads/<?php echo $_SESSION['img']; ?>" alt="">  
            <?php } ?>
              
          </div><!--Logo-->
            <div class="detalhe-usuario">
              <p><?php echo $_SESSION['nome']; ?></p>
              <p><?php echo pegaCargo($_SESSION['cargo']); ?></p>
            </div><!--Detalhe do usuario-->
          </a>
      </div><!--Usuario topo-->
      <div class="menu">
        
        <ul>
          <h2>Perfil</h2>
          <li>
            <a <?php selecionadoMenuADM('adicionar_usuario'); verificaPermissaoMenuADM(4); ?> href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>adicionar_usuario">
              <i class="fas fa-user-tie"></i>Adicionar Usuário
            </a>
        </li>
          <li>
            <a <?php selecionadoMenuADM('editar_usuario'); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>editar_usuario">
              <i class="far fa-id-card"></i> Editar Perfil
            </a>
          </li>
        <h2 <?php verificaPermissaoMenuADM(4); ?>>Gerenciamento</h2>
        <li>
            <a <?php selecionadoMenuADM('mais-vendido'); verificaPermissaoMenuADM(4); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>mais-vendido">
            <i class="fas fa-list-alt"></i> Mais Vendidos
            </a>
        </li>
        <li>
            <a <?php selecionadoMenuADM('contabilidade'); verificaPermissaoMenuADM(4); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>contabilidade">
              <i class="far fa-money-bill-alt"></i> Contabilidade
            </a>
        </li>
        <h2>Site</h2>
        <li>
            <a <?php selecionadoMenuADM('banner_site'); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>banner_site">
            <i class="fas fa-images"></i> Banner
            </a>
        </li>
        <li>
            <a <?php selecionadoMenuADM('categorias'); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>categorias">
            <i class="fas fa-ellipsis-h"></i> Menu/Categorias
            </a>
        </li>
        <li>
            <a <?php selecionadoMenuADM('subcategorias'); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>subcategorias">
            <i class="fas fa-ellipsis-v"></i> Subcategorias
            </a>
        </li>
        <h2>Pedidos</h2>
        <li>
            <a <?php selecionadoMenuADM('pedidos'); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>pedidos">
            <i class="fas fa-people-carry"></i> pedidos
            </a>
        </li>
  
        <h2>Estoque</h2>
        <li>
            <a <?php selecionadoMenuADM('lista_produtos'); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>lista_produtos">
            <i class="fas fa-stream"></i> Lista de Produtos
            </a>
        </li>
        <li>
            <a <?php selecionadoMenuADM('cadastra_produtos'); ?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>cadastra_produtos">
            <i class="fas fa-plus-square"></i> Cadastra produtos
            </a>
        </li>
        <h2 <?php verificaPermissaoMenuADM(3);?>>Entregas</h2>
       
        <li>
            <a <?php selecionadoMenuADM('correios'); verificaPermissaoMenuADM(3);?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>correios">
            <i class="fas fa-cubes"></i> Correios
            </a>
        </li>
        <li>
            <a <?php selecionadoMenuADM('sem_codigo'); verificaPermissaoMenuADM(3);?>  href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>sem_codigo">
            <i class="fas fa-barcode"></i> Sem Código
            </a>
        </li>
          <li class="sadebar_logout">
          <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>?loggout"><i class="fas fa-sign-out-alt"></i> Sair</a>
          </li>
          
        </ul>
      </div><!--Menu-->
  </sidebar>
  
 <main id="mainContent">
    <header>
        <i id="iconMenu" onclick="responsiveSidebar()" class="fas fa-bars"></i>
      <a href="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>?loggout"><i class="fas fa-sign-out-alt"></i> Sair</a>
    </header>
     
    <div class="main-content">
    
    <?php Painel::carregarPaginaADM(); ?>
    <div class="bg-modal" id="modal_conta" >
          <div class="modal"  style="width: 30%; height:350px">
              <div class ="fecha-modal">
                  <span class="close" id="fecha">&times;</span>
              </div><!--Fecha-modal-->
              <div class="titulo">Adicionar uma conta</div>
              <div class="conta">
                  <div class="form-conta">
                  <form action=""  method="post" id="form_cadastrar_conta">
                          <select name="data_conta">
                              <option value="01">Janeiro</option>
                              <option value="02">Fevereiro</option>
                              <option value="03">Março</option>
                              <option value="04">Abril</option>
                              <option value="05">Maio</option>
                              <option value="06">Junho</option>
                              <option value="07">Julho</option>
                              <option value="08">Agosto</option>
                              <option value="09">Setembro</option>
                              <option value="10">Outubro</option>
                              <option value="11">Novembro</option>
                              <option value="12">Desembro</option>
                          </select>
                          <select name="tipo" id="tipo">
                              <option value="imposto">Impostos</option>
                              <option value="funcionario">Funcionarios</option>
                              <option value="fixo">Fixos</option>
                          </select>
                          <label class="input_contabilidade" ref="imposto">
                              <input type="tel" id="imposto" name="imposto_conta" maxlength="4" placeholder="Imposto em %">
                          </label>
                          <label class="input_contabilidade desativado" ref="fixo">
                              <input type="tel" id="fixo" name="fixo_conta" placeholder="Valor fixo">
                          </label>
                          <label class="input_contabilidade desativado" ref="funcionario">
                              <input type="tel" id="funcionario" name="funcionario_conta" placeholder="Funcionario">
                          </label>
                          <input type="hidden" name="pagina" value="conta a paga">
                          <button class="botao botao-verde" type="submit">Salva</button>
                      </form>
                  </div><!--Form-conta-->
              </div><!--Conta-->
              <div class="resultado_conta"></div>
          </div><!--Modal-->
      </div><!--Bg-modal-->

      <div class="bg-modal" id="modal_filtrar" >
          <div class="modal"  style="width: 30%; height:350px">
              <div class ="fecha-modal">
                  <span class="close" id="fecha">&times;</span>
              </div><!--Fecha-modal-->
              <div class="titulo">Filtrar</div>
              <div class="filtrar">
                  <div class="form-busca">
                      <form method="post" id="form_busca_conta">
                          <input type="date" name="de">
                          Até
                          <input type="date" name="ate">
                          <button class="botao botao-cinza busca" name="busca">Busca</button>
                      </form>
                  </div><!--Form-busca-->
              </div><!--Filtrar-->
          </div><!--Modal-->
      </div><!--Bg-modal-->


      <div class="bg-modal" id="modal_publicidade">
          <div class="modal"  style="width: 30%; height:350px">
              <div class ="fecha-modal">
                  <span class="close" id="fecha">&times;</span>
              </div><!--Fecha-modal-->
              <div class="titulo">Publicidade</div>
              <div class="conta">
                  <div class="form-conta">
                      <form method="post" id="publicidade_envia">
                          <input type="text" name="publicidade_conta" id="valor_publicidade">
                          <input type="hidden" name="publicidade_data" id="data_publicidade">
                          <button class="botao botao-cinza" type="submit" name="acao" id="publicidade_envia">Salva</button>
                      </form>
                  </div><!--Form-conta-->
              </div><!--Conta-->
              <div class="resposta_publicidade"></div>
          </div><!--Modal-->
      </div><!--Bg-modal-->
    </div><!--Main Content-->
  </main>
</div><!--Flex dashboard-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<?php Painel::loadJSCkeditor(array('ckeditor'),'editar_produto'); ?>
<?php Painel::loadJSCkeditor(array('ckeditor'),'cadastra_produtos'); ?>
<script>
  CKEDITOR.replace('descricao');
</script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/funcoes.js"></script>

<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>js/jquery.maskMoney.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/jquery-img.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/jquery.ajaxform.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>js/jquery.mask.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/helperMask.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/main.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/menu.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/modal.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/usuarios.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/data_pedido.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/categoria.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/contabilidade.js"></script>

<?php Painel::loadJS(array('grafico'),''); ?>
<?php Painel::loadJS(array('rastreio'),'correios'); ?>
<?php Painel::loadJS(array('rastreio'),'sem_codigo'); ?>
<?php Painel::loadJS(array('pedidos'),'pedidos'); ?>


</body>
</html>