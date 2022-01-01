<?php 

	$id = $_GET['lista-de-pedido'];
	$pedidoInfo = \MySQL::conectar()->prepare("SELECT * FROM `tb_admin.pedidos.cliente` WHERE id = ?");
	$pedidoInfo->execute(array($id));
	$pedidos = $pedidoInfo->fetchAll();
		
	foreach ($pedidos as $key => $value) {
		

		$clienteInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.consumido` WHERE id = ?");
		$clienteInfo->execute(array($value['id_cliente']));
		$cliente = $clienteInfo->fetch();
	}
	
 ?>
<div class="box-content">
	<div class="wraper-table">
		<table>
			<a href="">Gerar PDF do Pedido</a>
			<tr class="titulo-detalhe"><td class="titulo-pedido" colspan="4">Detalhes do cliente</td></tr>
			<tr>
				<td>Cliente</td>
				<td><?php echo $cliente['nome']; ?></td>
			</tr>
			<tr>
			<?php
			if($cliente['cpf'] == ''){?>
				<td>CNPJ</td>
				<td><?php	echo $cliente['cnpj'];	?></td>
			<?php	}else{ ?>
				<td>CPF</td>
				<td><?php echo $cliente['cpf']; } ?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><?php echo $cliente['email']; ?></td>
			</tr>
			<tr class="titulo-detalhe"><td class="titulo-pedido" colspan="4">Endereço</td></tr>
			<tr>
				<td>CEP</td>
				<td><?php echo $cliente['cep']; ?></td>
			</tr>
			<tr>
				<td>UF</td>
				<td><?php echo $cliente['uf']; ?></td>
			</tr>
			<tr>
				<td>Estado</td>
				<td><?php echo $cliente['estado']; ?></td>
			</tr>
			<tr>
				<td>Cidade</td>
				<td><?php echo $cliente['cidade']; ?></td>
			</tr>
			<tr>
				<td>Bairro</td>
				<td><?php echo $cliente['bairro']; ?></td>
			</tr>
			<tr>
				<td>Rua</td>
				<td><?php echo $cliente['rua']; ?></td>
			</tr><tr>
				<td>Complemento</td>
				<td><?php echo $cliente['complemento']; ?></td>
			</tr>
			<tr>
				<td>Número</td>
				<td><?php echo $cliente['numero']; ?></td>
			</tr>
			<tr class="titulo-detalhe"><td class="titulo-pedido" colspan="4">Detalhes do pedido</td></tr>
			<tr>
				<td>Total de produto</td>
				<td><?php 
					//if($pedido_cliente['criado'] == $pedido_cliente['criado']){
					//	$total = count($value['id_pedido']);
					//	echo $total;
					//}
				?></td>
			</tr>
			<tr>
				<td>Tipo Frete</td>
				<td><?php
				if($value['tipo_frete'] == 'retira'){
					echo 'Retirar na loja';
				}else{
				 echo $value['tipo_frete'];
				} ?></td>
			</tr>
			<tr>
				<td>Data do pedido</td>
				<td><?php echo Painel::formatarData($value['criado']);?></td>
			</tr>
			
			<tr class="titulo-detalhe"><td class="titulo-pedido" colspan="4">Pedido</td></tr>
			<tr>
				<td>Prduto</td>
				<td>Quanidade</td>
				<td>Editar</td>
			</tr>
			<?php 
			if(isset($_GET['excluir'])){
				$idExcluir = intval($_GET['excluir']);
				Painel::deletar('tb_admin.produto.pedido',$idExcluir);
				Painel::redirect(INCLUDE_PATH_PAINEL.'detalhes-do-pedido');
			}else if(isset($_GET['order']) && isset($_GET['id'])){
				Painel::orderItem('tb_admin.produto.pedido',$_GET['order'],$_GET['id']);
			}
			$pedidoInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.produto.pedido` WHERE id_pedido = ?");
		$pedidoInfo->execute(array($value['id']));
		$pedido_produto = $pedidoInfo->fetchAll();
		foreach ($pedido_produto as $key => $pedido) {
				$produtoInfo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
				$produtoInfo->execute(array($pedido['id_produto']));
				$produto = $produtoInfo->fetch();
			?>
			<tr>
				
				<td><?php
				 echo $produto['nome'];
				 ?></td>
				<td><?php echo $pedido['qtd'];?></td>
				<td><a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto-pedido?id=<?php echo $pedido['id']; ?>"><i class="far fa-edit"></i> Editar</a></td>
			<td>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>
