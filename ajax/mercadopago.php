<?php
include('../config.php');

MercadoPago\SDK::setAccessToken("TEST-3335826690563666-051616-91050b67b03f58967be9b846ddebc6c7-757383440");

    $preference = new MercadoPago\Preference();

    $item = new MercadoPago\Item();
    $item->id = '0001';
    $item->title = 'Finalizando carrinho'; 
    $item->quantity = 1;
    $item->unit_price = $_SESSION['total'];

    @$preference->items = array($item);
       
    @$preference->save();

  echo $preference->init_point;

?>