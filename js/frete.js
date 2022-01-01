$(function(){
    $('[name=cep]').mask('99999-999');

	$('#formDestino').on('change', function(e) {
		if (e.keyCode == 13) {
			$("#formDestino").attr('value');
			return false;
		}
		$('.carregando').show();
		let formSerialized = $('#formDestino').serialize();
		$.post('ajax/frete.php', formSerialized, function(resultado) {
			resultado = JSON.parse(resultado);
			let pacFrete = resultado.pacpreco;
			let pacEntrega = resultado.pacprazo;
			let sedexFrete = resultado.sedexpreco;
			let sedexEntrega = resultado.sedexprazo;
			console.log(resultado);
			$('#resultado').css('display','block');
			$('#valorPac').html(`PAC <b>R$ ${pacFrete}</b> e o prazo de entrega é <b>${pacEntrega} dias úteis</b>.`);
			$('label #valorSedex').html(` SEDEX <b>R$ ${sedexFrete}</b> e o prazo de entrega é <b>${sedexEntrega} dias úteis</b>.`);
			 document.getElementById('pacFrete').value = pacFrete;
			 document.getElementById('sedexFrete').value = sedexFrete;
			 $('.carregando').hide();
		});
	});
	
	$('#pacFrete').on('click', function(e) {
		document.getElementById('tipofrete').value = 'PAC';
		if (e.keyCode == 13) {
			$("#formEnvio").attr('value');
			return false;
		}
		let formSerialized = $('#formEnvio').serialize();
		
		$.post('ajax/envio.php', formSerialized, function(resultado) {

			resultado = JSON.parse(resultado);
			let total = resultado.total;

			$('#valor_total').html(`R$ ${total}`);
			$('#botao_compra').css('display','flex');
			
		});
	});

	$('#sedexFrete').on('click', function(e) {
		document.getElementById('tipofrete').value = 'SEDEX';
		if (e.keyCode == 13) {
			$("#formEnvio").attr('value');
			return false;
		}
		let formSerialized = $('#formEnvio').serialize();
		
		$.post('ajax/envio.php', formSerialized, function(resultado) {
			
			resultado = JSON.parse(resultado);
			let total = resultado.total;

			$('#valor_total').html(`R$ ${total}`);
			$('#botao_compra').css('display','flex');
			
		});
	});
	
	if( document.getElementById('frete_cep').value != ''){
		var varName = setInterval(function(){

				let formSerialized = $('#formDestino').serialize();
			$.post('ajax/frete.php', formSerialized, function(resultado) {
				resultado = JSON.parse(resultado);
				let pacFrete = resultado.pacpreco;
				let pacEntrega = resultado.pacprazo;
				let sedexFrete = resultado.sedexpreco;
				let sedexEntrega = resultado.sedexprazo;
				
				$('#resultado').css('display','block');
				$('#valorPac').html(`PAC <b>R$ ${pacFrete}</b> e o prazo de entrega é <b>${pacEntrega} dias úteis</b>.`);
				$('label #valorSedex').html(` SEDEX <b>R$ ${sedexFrete}</b> e o prazo de entrega é <b>${sedexEntrega} dias úteis</b>.`);
				document.getElementById('pacFrete').value = pacFrete;
				document.getElementById('sedexFrete').value = sedexFrete;
			});
			clearInterval(varName)
		}, 1000);
}
});
