<?php 
include('../../config.php');
 $result = [];
    $sql = MySql::conectar()->prepare("SELECT count(product_id) as pedido, sum(quantity) vendidos,name, product_id, variant_id FROM `product_sold` INNER JOIN pedidos ON pedidos.id = order_id GROUP BY product_id ORDER BY pedido DESC LIMIT 10");
    $sql->execute();
  	while($grafico = $sql->fetch()){
  	     $result['nome'][] = mb_strimwidth($grafico[2],0,25,'...');
  	     $result['quantidade'][] = $grafico[3];
  		//$result = $grafico;
  	}
  	
  	
   	echo json_encode($result);

 ?>