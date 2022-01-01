$(function(){



	$('.btn.botao-vermelho.user-delete').click(function(e){
		e.preventDefault();
		var item_id = $(this).attr('item_id');
		var el = $(this).parent().parent();
		$.ajax({
			url:'ajax/usuarios.php',
			data:{id:item_id,tipo_acao:'deletar_usuario'},
			method:'post'
		}).done(function(){
			el.fadeOut();	

		})
	})

})