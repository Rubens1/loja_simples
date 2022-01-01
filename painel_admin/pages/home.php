<?php
	
			
?>

<div class="titulo-home">
	<h2>Bem Vindo(a) <?php echo $_SESSION['nome']; ?></h2>
</div>
<div class="dashboard-content">
	<div class="dashboard-flex-paret">
		
		<div class="dashboard-box box-verde">
			<div class="dashboard-box-wrapper">
				<div class="box-icon">
				<img width="90" src="<?php echo INCLUDE_PATH; ?>img/logo.png" alt="">
				</div><!-- Box-icon -->
				<div class="value">
				
				</div><!-- Value -->
				<div class="type">
					Verde
				</div><!-- Type -->
			</div><!-- Dashboard-box-wrapper -->
		</div><!-- Dashboard-box Box-verde -->
		<div class="dashboard-box box-azul">
			<div class="dashboard-box-wrapper">
				<div class="box-icon ">
					 <img width="41" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/icon/ml.png" alt="">
					</div><!-- Box-icon -->
					<div class="value">
					
					</div><!-- Value -->
					<div class="type">
						Azul
					</div><!-- Type -->
				</div><!-- Dashboard-box-wrapper -->
		</div><!-- Dashboard-box Box-azul -->
		<div class="dashboard-box box-roxo">
			<div class="dashboard-box-wrapper">
				<div class="box-icon ">
					 <img width="41" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/icon/ml.png" alt="">
					</div><!-- Box-icon -->
					<div class="value">
					
					</div><!-- Value -->
					<div class="type">
						Roxo
					</div><!-- Type -->
				</div><!-- Dashboard-box-wrapper -->
		</div><!-- Dashboard-box Box-pedido-roxo -->
		<div class="dashboard-box box-amarelo">
			<div class="dashboard-box-wrapper">
				<div class="box-icon ">
					 <img width="41" src="<?php echo INCLUDE_PATH_PAINEL_ADMIN; ?>img/icon/ml.png" alt="">
					</div><!-- Box-icon -->
					<div class="value">
					
					</div><!-- Value -->
					<div class="type">
						Amarelo
					</div><!-- Type -->
				</div><!-- Dashboard-box-wrapper -->
		</div><!-- Dashboard-box Box-pedido-amarelo -->
	</div><!-- Dashboard-flex-paret -->
</div><!-- Dashboard-content -->
<div class="grafico-contant"> 
    <div class="grafico">
        <div class="grafico-funcionario">
            <div class="g-titulo">Funcionario</div>
            <canvas id="funcionario"></canvas>
        </div><!--Grafico-funcionario-->
         <div class="grafico-publicidade">
             <div class="g-titulo">Publicidade</div>
             <canvas id="publicidade"></canvas>
        </div><!--Grafico-publicidade-->
        <div class="grafico-vendas">
            <div class="g-titulo">Vendido</div>
            <canvas id="vendas"></canvas>
        </div><!--Grafico-vendas-->
    </div><!--Grafico-->
</div><!--Grafico-Content-->

	