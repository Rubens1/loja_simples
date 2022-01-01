
<div class="chat">
<img src="<?php echo INCLUDE_PATH; ?>img/rede_social/whatsapp.png" alt="">
</div>

<footer>

  <div class="secao-superio" >
    <!-- logo -->
    <div class="f-logo">
      <h2>GLITEC</h2>
      <p>A Glitec foi criada em 2021 para oferecer uma seleta </p>
      <p> linha de produtos para decoração. Hoje já são mais de</p>
      <p> 3.000 itens (Adesivos de Parede, Espelhos Decorativos </p>
      <p> e Papel de Parede) que sempre são atualizados</p>
      <p> acompanhando as mais novas tendências e </p>
      <p> lançamentos internacionais.</p>
    </div><!-- F-logo -->
    

      <ul>
        <!-- Sobre a emresa -->
        <h1>Companhia</h1>
        <li><a href="<?php echo INCLUDE_PATH; ?>termos">Termos</a></li>
        <li><a href="<?php echo INCLUDE_PATH; ?>politica">Política</a></li>
        <li><a href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
        <li><a href="<?php echo INCLUDE_PATH; ?>empresa">Sobre nós</a></li>

      </ul>

     
      <!-- contato da empresa ----------------->
      <ul>
        <h1>Contatos</h1>
        <li><p>Telefone: (11) 98579-7473</p></li>
        <li><p>Email: sace@glitec.com.br</p></li>
        <li><p>WhatsApp: (11) 98579-7473</p></li>
      </ul>
      <div class="noticia-email">
        <h1>Receba notícias</h1>
        <div class="contato">
          <form action="" method="post">
          <input type="email" name="email" placeholder="Digita o seu email">
          <button type="submit"><i class="far fa-paper-plane"></i></button>
          </form>
        </div>
        

      </div><!-- Receba notícias-->
  </div><!-- Secao-Superio -->
  <div class="dwn-secao">
    
      <ul>
    
      </ul>
   
      
      <div class="social">
        <h1>Siguam nós nas redes sociais</h1>
        <div class="social-icons">
          <a href=""><i class="fab fa-facebook"></i></a>
          <a href=""><i class="fab fa-instagram"></i></a>
          <a href=""><i class="fab fa-youtube"></i></a>
        </div><!-- Social Icone -->
      </div><!-- Social -->
      
      <div class="noticia-email">
        <h1>SELOS:</h1>
        <!--<input type="email" name="email" placeholder="Digita o seu email">-->
      </div><!-- Receba notícias-->
    </div><!-- Dwn Secao-->

    <!-- Companhia data -->
    <p class="companhia">© GLINTEC Loja virtual de produtos eletronicos - CNPJ 33.166.156/0001-04 - TEL.: (11) 93369-1703</p>

</footer><!-- footer -->


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    
    <script src="<?php echo INCLUDE_PATH; ?>js/constants.js"></script>
    <script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/jquery.ajaxform.js"></script>
    <script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN ?>js/jquery.maskMoney.js"></script>
    <script src="<?php echo INCLUDE_PATH; ?>js/jquery.mask.js"></script>
    <!--<script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/helpe.js"></script> -->
    <script src="<?php echo INCLUDE_PATH; ?>js/produto.js"></script>
    <script src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>js/modal.js"></script>

    <?php Painel::loadJSEcommerce(array('imgZoom'),'produto'); ?>
    <?php Painel::loadJSEcommerce(array('frete'),'carrinho'); ?>
    <?php Painel::loadJSEcommerce(array('jquery.mask'),'meuperfil'); ?>
    <?php Painel::loadJS(array('jquery.maskMoney'),'meuperfil'); ?>
    <?php Painel::loadJSCliente(array('mask'),'meuperfil'); ?>
    <?php Painel::loadJSCliente(array('cep'),'adicionar_endereco'); ?>
    <?php Painel::loadJSCliente(array('cep'),'endereco'); ?>


    <script src="<?php echo INCLUDE_PATH; ?>js/menu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />

    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <!--<script src="<?php echo INCLUDE_PATH; ?>js/filter.js"></script>--> 
    <?php Painel::loadJSEcommerce(array('emal'),'contato'); ?>
    <script src="<?php echo INCLUDE_PATH; ?>js/pesquisa.js"></script>
    <script src="<?php echo INCLUDE_PATH; ?>js/lightslider.js"></script>

    <script>
      var limite = document.getElementById('quantidade_produto');
      var item = document.getElementById('qtd_item');
      $('#min_qtd').click(function(){
        var total_min = item.value - 1;
        if(total_min > 0){
          item.value = total_min;
        }
        
      });
      $('#max_qtd').click(function(){
        var total_max = parseInt(item.value) + 1;
        if(total_max <= limite.value){
          item.value = total_max;
        }
      });
    </script>

  </body>
</html>
