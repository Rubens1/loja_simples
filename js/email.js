$(function(){
	

	$('body').on('submit','form.ajax-form',function(){
		var form = $(this);
		$.ajax({
			beforeSend:function(){
				$('.overlay-loading').fadeIn();
			},
			url:include_path+'ajax/email.php',
			method:'post',
			dataType: 'json',
			data:form.serialize()
		}).done(function(data){
			if(data.sucesso){
				//Tudo certo vamos melhorar a interface!
				$('.overlay-loading').fadeOut();
				$('.sucesso').slideToggle();
				setTimeout(function(){
					$('.sucesso').fadeOut();
				},3000)
			}else{
				//Algo deu errado.
				$('.overlay-loading').fadeOut();
			}
		});
		return false;
	})

})