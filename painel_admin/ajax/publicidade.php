<?php 
    include('../../config.php');
    $result = [];
    //$mesesNome = [ 1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro' ];
    $date = date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m'). '-01')));
  	$sql = MySql::conectar()->prepare("SELECT sum(publicidade), data FROM `contabilidade` WHERE data >= '$date' GROUP BY month(data) ORDER BY data DESC");
  	$sql->execute();
  	while($funcionario = $sql->fetch()){
        $result['total'][] = $funcionario[0];
        $result['meses'][] =  Painel::formatarData2($funcionario[1]);
    }
    
    echo json_encode($result);
    

 ?>