<?php

class Mercadolivre{

    public static function cartao($total,$bandeira,$parcelas,$token,$pedido_id,$email,$first_name,$last_name,$celular_ddd,$celular_num,$cep,$endereco,$numero,$complemento){
        $payment_data = array(
			"transaction_amount"   => $total, //valor da compra
			"token"                => $token, //token gerado pelo javascript da index.php
			"description"          => "Pagamento do pedido $pedido_id", //descrição da compra
			"installments"         => $parcelas, //parcelas
			"payment_method_id"    => "$bandeira", //forma de pagamento (visa, master, amex...)
			"payer"                => array ("email" => "$email"), //e-mail do comprador
			"statement_descriptor" => "Colando", //nome para aparecer na fatura do cartão do cliente
			"additional_info" => array(
				"payer" => array(
					"first_name" => "$first_name",
					"last_name" => "$last_name",
					"phone" => array(
						"area_code" => "$celular_ddd",
						"number" => "$celular_num",
					),
					"address" => array(
						"zip_code" => "$cep",
						"street_name" => "$endereco",
						"street_number" => $numero
					)
				),
				"shipments" => array(
					"receiver_address" => array(
						"zip_code" => "$cep",
						"street_name" => "$endereco",
						"street_number" => $numero,
						"floor" => "",
						"apartment" => "$complemento",
					)
				)
			)	
		);
    }

    public static function boleto(){
        // PAGAMENTO POR BOLETO
			$itens = [];
			$i = 0;
			while($campo = mysqli_fetch_array($q_cart)) {
				$cart_id			= $campo['id'];
				$produto_id 		= $campo['produto_id'];
				$produto_nome 		= $campo['nome'];				
				$posicao 			= $campo['posicao'];
				$produto_tamanho 	= $campo['tamanho'];
				$produto_quantidade = intval($campo['quantidade']);
				$produto_preco		= floatval($campo['preco']);
							
				$itens[] = array(
				'id' => $produto_id,
				'title' => $produto_nome,
				'quantity' => $produto_quantidade,
				'unit_price' => $produto_preco
				);
			}


		

			$payment_preference = array(
				"transaction_amount" => $total,
				"description" => "Pagamento do pedido $pedido_id",
				"payment_method_id" => "bolbradesco",
				"payer"=> array(
					"first_name" => "$first_name",
					"last_name" => "$last_name",
					"email"=> "$email",
					"identification" =>  array(
						"number" =>  "$cpf",
						"type" =>  "CPF"
					)
				),
				"additional_info"=>  array(
					"items"=> $itens, 
					"payer"=>  array(
						"first_name" => "$first_name",
						"last_name" => "$last_name",
						"address"=>  array(
							"street_name"=> "$endereco",
							"street_number"=> $numero,
							"zip_code"=> "$cep",
						)
					),
					"shipments"=>  array(
						"receiver_address"=>  array(
							"street_name"=> "$endereco",
							"street_number"=> $numero,
							"zip_code"=> "$cep",
						)
					)
				)
			);


		
			$status = 'Pendente';
			$status2 = 'Pendente';
			$status_label = 'Pedido Efetuado';
			$data_pagamento = "";
			
			$payment = $mp->post("/v1/payments", $payment_preference);
			$transacao_id = $payment['response']['id'];
			$status_pagamento = $payment['response']['status'];
			$transaction_amount = $payment['response']['transaction_amount'];	
			$link_pagamento = $payment['response']['transaction_details']['external_resource_url'];
			if($status_pagamento == 'approved') {
				$status = 'Aprovado';
				$data_pagamento = "now()";
				$status_label = 'Pedido Pago';
			}
			if($status_pagamento == 'rejected') {
				$status = 'Cancelado';
				$status2 = 'Cancelado';
				$status_label = 'Pagamento Cancelado';
			}
			
			if($tipo_pag == 'boleto' || $status_pagamento == 'approved') {
				setcookie("carrinho", "", time()-3600);
			}
			
			$sql = MySql::conectar()->prepare("UPDATE pedidos set status = ?, status_pedido = ?, transacao_id = ?, link_pagamento =  WHERE id = $pedido_id");
            $sql->execute(array($status2, $status2,$transacao_id,$link_pagamento));
			$r_entrega = $sql->fetch();
			$nome = $r_entrega['nome'];
			$endereco = $r_entrega['endereco'] . ', ' . $r_entrega['numero'];
			$complemento = $r_entrega['complemento'];
			if($complemento != '') {
				$endereco.= " ($complemento)";
			}
			$bairro = $r_entrega['bairro'];
			$cidade = $r_entrega['cidade'];
			$estado = $r_entrega['estado'];
			$cep = $r_entrega['cep'];
			
			$entrega_html = "<p>Destinatário: $nome</p>";
			$entrega_html .= "<p>Endereço: $endereco</p>";
			$entrega_html .= "<p>Bairro: $bairro</p>";
			$entrega_html .= "<p>Cidade: $cidade / $estado</p>";
			$entrega_html .= "<p>CEP: $cep</p>";
			
			
			



			
			//envia um post para mandar o email que o pagamento foi gerado
			$content =	http_build_query( array(
				'contents' => 'contents_pedido.html',
				'numero_pedido' => $pedido_id,
			));

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://www.colando.com.br/email/index.php');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, true);

			$result = curl_exec($ch);
			curl_close($ch);
    }

}
?>