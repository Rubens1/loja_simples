$(function(){
	var url = include_path+'ajax/pedidos.php';

	/*
		Carregar datas de pedidos
	*/
	$('.data_dia').click(function(e){
		e.preventDefault();
		var data_dia = $(this).attr('data_dia');
		objData = new Date(data_dia+' 00:00:00')
        objData.setDate(objData.getDate());
        var embalado = $(this).attr('embalado');
        var conferido = $(this).attr('conferido');
		var reenvio = $(this).attr('reenvio');
        $('.data_dia').removeClass('data_ativo');  
        $(this).addClass('data_ativo');        
		$('.conteudo_tipos').addClass('ativo_item');
		$('.imprima_todos').attr('href', "impressao/codigo_produto.php?data="+objData.toLocaleDateString());
		$('.carregar').show();
		$('#pedido_do_dia').html('');
		$.ajax({
			url: url,
			data:{data_dia:data_dia,embalado:embalado,conferido:conferido,reenvio:reenvio},
			method:'post',success:function(data){
				$('#pedido_do_dia').html(data);
				$('.carregar').hide();
            }
		})
		
		/*
			Carregar os links para poder produzir os produtos
		*/
		$('.tipo').html('')
		$.ajax({
			url: url,
			data:{data:data_dia,tipo_produto:'tipo'},
			method:'post',success:function(data){
				res = JSON.parse(data);
				var quantidade = res[1];
				console.log(quantidade);
				var mostrar = res[0];
				Object.entries(mostrar).forEach(element => {
					var tipo = element[0];
					var quantidade = element[1];
					switch (tipo) {
						case 'Aprovado':
							var pedidos = '<div class="tipo_item aprovado" tipo="aprovado_'+objData.toLocaleDateString()+'">Aprovado <span>'+quantidade+'</span></div>';
							break;
						case 'Pendente':
							var pedidos = '<div class="tipo_item pendente" tipo="pendente_'+objData.toLocaleDateString()+'">Pendente <span>'+quantidade+'</span></div>';
							break;
						case 'Canselado':
							var pedidos = '<div class="tipo_item cancelado" tipo="canselado_'+objData.toLocaleDateString()+'">Canselado <span>'+quantidade+'</span></div>';
							break;
						
					}
					$('.tipo').append(pedidos);						
				 })
				 /*
					Carregar tipos de status
				*/
				$('.tipo_item').click(function(e){
					e.preventDefault();
					var tipo = $(this).attr('tipo');  
					$('.carregar').show();
					$('#pedido_do_dia').html('');
					$.ajax({
						url: url,
						data:{tipo:tipo,data_dia:data_dia,embalado:embalado,conferido:conferido,reenvio:reenvio},
						method:'post',success:function(data){
							$('#pedido_do_dia').html(data);
							
						}
					})
				})

			}
		})
		
	})
	
})