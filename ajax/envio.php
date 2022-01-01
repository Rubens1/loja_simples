<?php
    include('../config.php');
    $total = Carrinho::valorTotal();

    if(isset($_POST['valorFrete'])){
        $frete = $_POST['valorFrete'];
        $tipo = $_POST['tipofrete'];
        $frete = Painel::formatarMoedaBd($frete);
        $valor = $total + $frete;
        $_SESSION['total'] =  $valor;
        $_SESSION['valor_frete'] = $frete;
        $_SESSION['tipo_frete'] = $tipo;
        $valor = Painel::convertMoney($valor);
        $retorno = array('total'  => strval($valor));
        die(json_encode($retorno));
    }

?>