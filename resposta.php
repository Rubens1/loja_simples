<?php
    include('config.php');

    MercadoPago\SDK::setAccessToken("TEST-3335826690563666-051616-91050b67b03f58967be9b846ddebc6c7-757383440");
 
 
    $merchant_order = null;
    switch($_GET["topic"]) {
        case "payment":
            $payment = MercadoPago\Payment::find_by_id($_GET["id"]);
 
            $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
        break;
 
        case "plan":
            $plan = MercadoPago\Plan.find_by_id($_GET["id"]);
        break;
 
        case "subscription":
            $plan = MercadoPago\Subscription.find_by_id($_GET["id"]);
        break;
 
        case "invoice":
            $plan = MercadoPago\Invoice.find_by_id($_GET["id"]);
        break;
 
        case "merchant_order":
            $merchant_order = MercadoPago\MerchantOrder::find_by_id($_GET["id"]);
        break;
    }
 
    $paid_amount = 0;
    if ($payment->status == 'approved'){
        $paid_amount += $payment->transaction_amount;
    }
 
    if($paid_amount >= $payment->transaction_amount){
        if ($merchant_order->shipments > 0) { 
            if($merchant_order->shipments[0]->status == "ready_to_ship") {
                print_r("Totally paid. Print the label and release your item.");
            }
        } else { 
            print_r("Totally paid. Release your item.<br>");
            $external_ref = $payment->external_reference;
            $ext_email = $payment->payer->email;
            $ext_val = $payment->transaction_amount;
            $item_id = $payment->items->id;

            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.pedidos` WHERE id = ? AND external_ref = ?");
            $sql->execute(array($item_id,$external_ref));

            if($sql->rowCount() == 1){
                $atualizar_qtd = MySQL::conectar()->prepare("UPDATE `tb_cliente.pedidos` SET status = 1 WHERE id = ?");
                $atualizar_qtd->execute(array($item_id));
            }

        }
    } else {
            print_r("Erro.");
    }
    
?>