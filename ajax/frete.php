<?php
  include('../config.php');
    $produtos = Carrinho::listarProdutos();
    $_SESSION['cep_cadastro'] = $_POST['cep'];
    $cep = Painel::formatarCep($_POST['cep']);
    
    /* DADOS DO PRODUTO A SER ENVIADO */
    foreach ($produtos as $id => $produto){ 
    $valor         = $produto['preco_venda'];
    if($produto['peso'] < 1){
        $peso = 1;
    }else{
        $peso = $produto['peso']*$produto['quantidade'];

    }
    $altura        = $produto['altura'];
    $largura       = $produto['largura'];
    $comprimento   = $produto['comprimento'];
    
    }
    if(isset($largura, $altura, $comprimento)){

    
    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
    $url .= "nCdEmpresa=";
    $url .= "&sDsSenha=";
    $url .= "&sCepOrigem=08250540";
    $url .= "&sCepDestino=" .$cep;
    $url .= "&nVlPeso=" .$peso;
    $url .= "&nVlLargura=".$largura;
    $url .= "&nVlAltura=".$altura;
    $url .= "&nCdFormato=1";
    $url .= "&nVlComprimento=".$comprimento;
    $url .= "&nCdMaoProria=n";
    $url .= "&nVlValorDeclarado=0";
    $url .= "&sCdAvisoRecebimento=n";
    $url .= "&nVlDiametro=0";
    $url .= "&StrRetorno=xml";
    $url .= "&nIndicaCalculo=3";
    $url .= "&nCdServico=04510"; // SEDEX 04014 PAC 04510
    

    
$unparsedResult = file_get_contents($url);
$xml = simplexml_load_string($unparsedResult);

        
    $url2 = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
    $url2 .= "nCdEmpresa=";
    $url2 .= "&sDsSenha=";
    $url2 .= "&sCepOrigem=08250540";
    $url2 .= "&sCepDestino=" .$cep;
    $url2 .= "&nVlPeso=" .$peso;
    $url2 .= "&nVlLargura=".$largura;
    $url2 .= "&nVlAltura=".$altura;
    $url2 .= "&nCdFormato=1";
    $url2 .= "&nVlComprimento=".$comprimento;
    $url2 .= "&nCdMaoProria=n";
    $url2 .= "&nVlValorDeclarado=0";
    $url2 .= "&sCdAvisoRecebimento=n";
    $url2 .= "&nVlDiametro=0";
    $url2 .= "&StrRetorno=xml";
    $url2 .= "&nIndicaCalculo=3";
    $url2 .= "&nCdServico=04014"; // SEDEX 04014 PAC 04510

        $unparsedResult2 = file_get_contents($url2);
        $xml2 = simplexml_load_string($unparsedResult2);
    
        $retorno = array(
            'pacpreco' => strval($xml->cServico->Valor),
            'pacprazo' => strval($xml->cServico->PrazoEntrega),
            'sedexpreco' => strval($xml2->cServico->Valor),
            'sedexprazo' => strval($xml2->cServico->PrazoEntrega)
        );
    die(json_encode($retorno));
    }
 ?>
