$(function(){
	var url = 'ajax/correios.php';
	/*
		Carregar informação dos rastreio dos correios
	*/

	$('.correios_botao').click(function(e){
		e.preventDefault();
		var rastreio = $(this).attr('rastreio');
        $('.carregar').show();
		$('.rastreio_correios').html('');
		$.ajax({
			url: url,
			data:{rastreio:rastreio},
			method:'post',success:function(data){
                $('.rastreio_correios').html(data);
				$('.carregar').hide();
            }
		})
	})
	
	/*
		Fazer contato 
	*/
	
	$('.botao_contato').click(function(e){
		e.preventDefault();
		var contato = $(this).attr('contato');
        var html = $(this);
		$.ajax({
			url: url,
			data:{contato:contato},
			method:'post',success:function(data){
                html.html(data);
               
            }
		})
	})

	/*
		Fazer contato 
	*/
	
	$('.form_rastreio').submit(function(e){
		e.preventDefault();
		var id_rastreio = $(this).attr('rastreio_id');
        var codigo_rastreio = $('.codigo_rastreio_'+id_rastreio).val();
		var el = $(this).parent().parent();
		$.ajax({
			url: url,
			data:{id_rastreio:id_rastreio,codigo_rastreio:codigo_rastreio},
			method:'post',success:function(data){
                $('.resultado_envio').html(data);
            }
		}).done(function(){
			el.fadeOut();	
		})
		
	})
	
})