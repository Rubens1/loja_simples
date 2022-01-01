$(function(){
	$('[name=preco]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	$('[name=promocao]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	$('[name=custo]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	$('[name=imposto_conta]').mask('##0%', {reverse: true});
	$('[name=funcionario_conta]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $('[name=fixo_conta]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	$('[name=publicidade_conta]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	$('[name=peso]').mask('9.999');
	$('[name=altura]').mask('9.99');
	$('[name=complimento]').mask('9.99');
	$('[name=largura]').mask('9.99');

	$('[name=tipo_tamanho]').change(function(){
		var val = $(this).val();
		if(val == 'letra'){
			$('#tamanho_letra').parent().show();
			$('#tamanho_numero').parent().hide();
		}else{
			$('#tamanho_letra').parent().hide();
			$('#tamanho_numero').parent().show();
		}
	})
})