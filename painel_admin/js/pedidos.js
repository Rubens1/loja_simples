$(function(){
	var url = 'ajax/pedidos.php';

    /*
		Cadastra observação do pedido
	*/

	$('#formulario_obs').on('submit',function(e){
		e.preventDefault();
			var acao_id = document.getElementById('obs_botao').value;
			var obs = document.getElementById('obs').value;
			var id_obs = document.getElementById('id_obs').value;
			$.ajax({
				url:url,
				data:{id_obs:id_obs,acao_obs:acao_id,obs:obs},
				method:'post',success:function(data){
					$('.bg-modal .modal .obs_pedido').html(data);
				
				}
			})
	})

    /*
		Muda o status do pedido
	*/

    $('.conferido_status').click(function(e){
		e.preventDefault();
		var status_id = $(this).attr('status_id');
		var status = $(this).attr('status');
		var el = $(this).parent().parent();
		$.ajax({
			url:url,
			data:{id:status_id,status_interno:status},
			method:'post'
		}).done(function(){
			el.fadeOut();	

		})
	})

	 /*
		Checklist do produto que o cliente pedio
	*/

    $('.check_produto').click(function(){
		var produto_id = $(this).attr('produto_id');
		var pedido_id = $(this).attr('pedido_id');
		$.ajax({
			url:url,
			data:{produto_id:produto_id,pedido_id:pedido_id},
			method:'post',success:function(data){
				$('.produto_verificado').html(data);
			}
		})
	})

    /*
		Carregar a identificação do pedido para o formulario que observa 
	*/

    $('.obs_pedido_cliente').click(function(e){
		e.preventDefault();
		var id_obs = $(this).attr('id_obs');
		document.querySelector("[name='id_obs']").value = id_obs;
		$('.bg-modal .modal .obs_pedido').html('');
	})

	/*
		Cadastra o status da produção do produto feito/fazer
	*/

	$('.op').click(function(e){
		e.preventDefault();
		var produto_id = $(this).attr('produto_id');
		var op = $(this).attr('op');
		var estoque = $(this).attr('estoque');
		var html = $(this).parent();
		$.ajax({
			url: url,
			data:{produto_id:produto_id,op:op,estoque:estoque,pagina:'produtos'},
			method:'post',success:function(data){
				html.html(data)				

            }
		})
	})

	
})