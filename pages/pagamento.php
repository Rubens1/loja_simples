<?php
$ext = rand(1, 9999999999999);
$enderecoCliente = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.endereco` WHERE id_cliente = ?");
$enderecoCliente->execute(array($_SESSION['id_usuario']));
$endereco = $enderecoCliente->fetch();
if(!isset($_SESSION['carrinho']) && $_SESSION['carrinho'] == 0 ){
  echo Painel::redirect(INCLUDE_PATH);
    //header("Location: ".INCLUDE_PATH);
}else if($enderecoCliente->rowCount() == 0){
  // Criar um formulario onde o usuario cadastra o seu endereço
  
  echo Painel::redirect(INCLUDE_PATH_PAINEL_CLIENTE.'endereco');
}else{
  $sql = MySql::conectar()->prepare("SELECT id FROM `tb_cliente.informacoes` WHERE id = ?");
  $sql->execute(array($_SESSION['id_usuario']));
  $info = $sql->fetch();
  $sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.endereco` WHERE cep = ?");
  $sql->execute(array($_SESSION['cep_cadastro']));
  $enderecos = $sql->fetch();
  if($sql->rowCount() > 0){
    $endereco = $enderecos['id'];
  }else{
    $endereco = $_SESSION['id_endereco'];
  }
  if(!isset($_SESSION['realizado'])){
    $stmt = MySQL::conectar()->prepare("INSERT INTO `tb_cliente.pedidos` (id_cliente,id_endereco, valor_total, external_ref, status, criado, modificado,tipo_frete,valor_frete,forma_pagamento) VALUES(?,?,?,?,0,NOW(),NOW(),?,?,'mercadopago')");
    $stmt->execute(array($info['id'],$endereco, $_SESSION['total'],$ext,$_SESSION['tipo_frete'],$_SESSION['valor_frete']));
    $_SESSION['lastId'] = \MySQL::conectar()->lastInsertId();

    foreach ($_SESSION['carrinho'] as $id => $qtd) {
      $pedido_cliente = MySQL::conectar()->prepare("SELECT * FROM `tb_cliente.pedidos` WHERE id = ?");
      $pedido_cliente->execute(array($_SESSION['lastId']));
      $cliente_pedido = $pedido_cliente->fetch();
      $stmtdois = MySQL::conectar()->prepare("INSERT INTO `tb_cliente.produto_pedido` (id_pedido, id_produto, qtd)  VALUES(?,?,?)");
      $stmtdois->execute(array($cliente_pedido['id'], $id, $qtd));
      $pega_dados = MySQL::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
      $pega_dados->execute(array($id));
      $dados = $pega_dados->fetch();
      
      $atualizar_qtd = MySQL::conectar()->prepare("UPDATE `tb_admin.estoque` SET quantidade = quantidade-$qtd, vendido = vendido+$qtd WHERE id = ?");
      $atualizar_qtd->execute(array($id));
    }

    $_SESSION['realizado'] = 1;
    

}

    // Configura credenciais
    MercadoPago\SDK::setAccessToken('TEST-3335826690563666-051616-91050b67b03f58967be9b846ddebc6c7-757383440');

    // Cria um objeto de preferência
    $preference = new MercadoPago\Preference();


    $preference = new MercadoPago\Preference();

    $item = new MercadoPago\Item();
    $item->id = $cliente_pedido['id'];
    $item->title = 'Finalizando carrinho'; 
    $item->quantity = 1;
    $item->unit_price = $_SESSION['total'];

    @$preference->items = array($item);

    $preference->external_reference = $ext;

    //$preference->back_uris = ['success' => 'https://google.com.br','pending' => '#', 'feilure' => ''];

    $preference->notification_url = 'http://localhost.com/loja/resposta.php';

    @$preference->save();

    echo Painel::redirect($preference->init_point);
    
}
  ?>