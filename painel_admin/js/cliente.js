$(function(){
	var url = 'ajax/pedidos.php';
    /*
		Informa os detalhes do pedidos
	*/

	$('.detalhes_cliente').click(function(e){
		e.preventDefault();
		var pedido_id = $(this).attr('id_pedido');
		$('.carregar').show();
		$('.bg-modal .modal .user_pedido').html('');
		$.ajax({
			url: url,
			data:{id_pedido:pedido_id,pagina:'usuario'},
			method:'post',success:function(data){
                $('.user_pedido').html(data);
				$('.carregar').hide();
            }
		})
	})

	 /*
		Mostrar produtos do cliente 
	*/

	$('.detalhes_cliente').click(function(e){
		e.preventDefault();
		var pedido_id = $(this).attr('id_pedido');
		$('.carregar').show();
		$('.bg-modal .modal .produtos_pedido').html('');
		$.ajax({
			url: url,
			data:{id_pedido:pedido_id,pagina:'produto'},
			method:'post',success:function(data){
                $('.produtos_pedido').html(data);
				$('.carregar').hide();
            }
		})
	})
})
