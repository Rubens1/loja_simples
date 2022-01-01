<?php

    class Contabilidade{

        //Lista todos os rendimentos da empresa
        public static function lista($data1,$data2){
           

                $stmt = MySql::conectar()->prepare("SELECT * FROM `tb_cliente.pedidos` WHERE criado >= '$data1' AND criado <= '$data2' ORDER BY criado desc");
                $stmt->execute();

                $dados = [];
                $dataAtual = Painel::formatarDataUS('-1 day', strtotime($data1));
                while ($pedido = $stmt->fetch()) {
                    $data = Painel::formatarDataUS($pedido['criado']);
                    if($data != $dataAtual){
                        $dataAtual = $data;
                        $dados["$dataAtual"]["pedidos"] = 0;
                        $dados["$dataAtual"]["faturamento"] = 0;
                        $dados["$dataAtual"]["vendas"] = 0;
                        $dados["$dataAtual"]["custo"] = 0;
                    }        
                    $dados["$dataAtual"]["pedidos"] += 1;
                    if($pedido['modificado'] != NULL  && $pedido['status'] == 1){
                        $dados["$dataAtual"]["vendas"] += 1;
                        $dados["$dataAtual"]["faturamento"] += $pedido['valor_total'];
                        $dados["$dataAtual"]["custo"] += 5.50;
                    }

                }

                $response = array();
                foreach($dados as $dataAtual => $dado){
 
                    $response[$dataAtual]['data'] = Painel::formatarDataUS($dataAtual);
                    $response[$dataAtual]['pedidos'] = $dado['pedidos'];
                    $response[$dataAtual]['vendas'] = $dado['vendas'];
                    $response[$dataAtual]['faturamento'] = Painel::convertMoney($dado['faturamento']);
        
                    
        
                    if($dado['vendas'] > 0){
                        $response[$dataAtual]['ticket_medio'] = Painel::convertMoney(($dado['faturamento'] / $dado['vendas']));
                    } else {
                        $response[$dataAtual]['ticket_medio'] =  '0,00';
                    }
                    
                    //$response[$dataAtual]['cartao'] = Painel::convertMoney(($dado['faturamento'] * 0.065));
                    //$response[$dataAtual]['plataforma'] = Painel::convertMoney(($dado['faturamento'] * 0.02));
                    $response[$dataAtual]['plataforma'] = 0;
                    $response[$dataAtual]['produto'] = Painel::convertMoney($dado['custo']);
                    $response[$dataAtual]['correios'] = Painel::convertMoney2(($dado['vendas'] * 24));
        
                    $response[$dataAtual]['%produto'] = $dado['faturamento'] > 0 ? Painel::convertMoney(($dado['custo'] / $dado['faturamento'] * 100)) . '%' : '';
        
                    $stmt2 = MySql::conectar()->prepare("SELECT * FROM `tb_admin.contabilidade` WHERE data = ?");
                    $stmt2->execute(array(@$dataAtual));
                    $res = $stmt2->fetch();
                    $dias_mes = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($dataAtual)), date('Y', strtotime($dataAtual)));
                    
                    $response[$dataAtual]['imposto'] =       Painel::convertMoney((($dado['faturamento'] * $res['imposto'] / 100)));
                    $response[$dataAtual]['funcionarios'] =  Painel::convertMoney(($res['funcionarios'] / $dias_mes));
                    $response[$dataAtual]['fixos'] =         Painel::convertMoney(($res['fixos'] / $dias_mes));
                    $response[$dataAtual]['publicidade'] =   Painel::convertMoney($res['publicidade']);
                    
                    if($res['imposto'] > 0  && $res['fixos'] > 0 && $res['publicidade'] > 0){
                                
                        $valor_total =  $res['publicidade']
                                    + ($dado['faturamento'] * 0.065) 
                                    + ($dado['faturamento'] * 0.02) 
                                    +  $dado['custo'] 
                                    + ($dado['vendas'] * 24) 
                                    + ($dado['faturamento'] * $res['imposto'] / 100) 
                                    + ($res['funcionarios'] / $dias_mes) 
                                    + ($res['fixos'] / $dias_mes);
                    
                        $valor_lucro = $dado['faturamento'] - $valor_total; 
        
                        $response[$dataAtual]['total'] = Painel::convertMoney($valor_total);
                        $response[$dataAtual]['lucro'] =   $valor_lucro > 0 ? Painel::convertMoney($valor_lucro)
                                    : Painel::convertMoney($valor_lucro);
        
                    } else {
                        $response[$dataAtual]['lucro'] = '';
                        $response[$dataAtual]['total'] = '';
                    }        
                }
                return $response;
           
        }

       //Adicionar conta no sistema
       public static function contaCadastro(){
       }

        /*
            Formatar data e cadastrar todos os dias do mes 
        */
        function diasDoMes($data){
            $mes = date('m', strtotime($data));
            $ano = date('Y', strtotime($data));
    
            $dias_mes = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($data)), date('Y', strtotime($data)));
            $dias_lista = "";
            for ($i=1; $i <= $dias_mes; $i++) { 
                $dia = str_pad($i , 2 , '0' , STR_PAD_LEFT);
                $dias_lista .= "'$ano-$mes-$dia', ";
            }
            
            $dias_lista = substr($dias_lista, 0, -2);
    
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.contabilidade` WHERE data in ($dias_lista)");
            $sql->execute(array($data));
            if($sql->rowCount() < $dias_mes){
                for ($i=1; $i <= $dias_mes; $i++) {
                    $dia =  str_pad($i , 2 , '0' , STR_PAD_LEFT);
                    $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.contabilidade` (data) values ('$ano-$mes-$dia')");
                    $sql->execute();
                }
            }
            return $dias_lista;
        }
    }
?>