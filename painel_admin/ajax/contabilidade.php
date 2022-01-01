<?php
    include('../../config.php');
        /*
            Criar mais uma conta no setor de contabilidade
        */
        if(isset($_POST['data_conta'])){
            $mes = $_POST['data_conta'];
            $tipo = $_POST['tipo'];
            $imposto = Painel::formatarPorcentagem($_POST['imposto_conta']);
            $fixos = Painel::formatarMoedaBdJS($_POST['fixo_conta']);
            $funcionarios = Painel::formatarMoedaBdJS($_POST['funcionario_conta']);
            $data = date('Y').'-'.$mes. '-'.date('d');
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.contabilidade` WHERE data = ?");
            $sql->execute(array($data));
            $dias_lista = Contabilidade::diasDoMes($data);
                switch ($tipo) {
                    case 'imposto':
                        $atualizarimposto = MySql::conectar()->prepare("UPDATE `tb_admin.contabilidade` SET imposto = ? WHERE data in ($dias_lista)");
                        $atualizarimposto->execute(array($imposto));
                        echo Painel::alert('sucesso','Imposto cadastrado com sucesso');
                        break;
                    case 'fixo':
                        $atualizarfixo = MySql::conectar()->prepare("UPDATE `tb_admin.contabilidade` SET fixos = ? WHERE data in ($dias_lista)");
                        $atualizarfixo->execute(array($fixos));
                        echo Painel::alert('sucesso','Gasto fixo cadastrado com sucesso');
                        break;
                    case 'funcionario':
                        $atualizarfuncionario = MySql::conectar()->prepare("UPDATE `tb_admin.contabilidade` SET funcionarios = ? WHERE data in ($dias_lista)");
                        $atualizarfuncionario->execute(array($funcionarios));
                        echo Painel::alert('sucesso','Gasto com funcionario cadastrado com sucesso');
                        break;
                }
            
        }

        /*
            Cadastrar casto com publicidade
        */
        if(isset($_POST['publicidade_conta'])){
            $data = $_POST['publicidade_data'];
            $publicidade = Painel::formatarMoedaBdJS($_POST['publicidade_conta']);
                $atualizarpublicidade = MySql::conectar()->prepare("UPDATE `tb_admin.contabilidade` SET publicidade = ? WHERE data = ?");
                $atualizarpublicidade->execute(array($publicidade,$data));
                $data_mostra = Painel::formatarData($data);
                echo Painel::alert('sucesso','Gasto com publicidade na data '.$data_mostra.' foi cadastrada com sucesso');
               
                    //Painel::redirecionar(INCLUDE_PATH_PAINEL_ADMIN.'contabilidade');
                

        }
        
?>