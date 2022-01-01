	$(function() {
		$('[name=preco_max],[name=preco_min]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
		$('[name=promocao_max],[name=promocao_min]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
	
		/*setInterval(function(){
			sendRequest();
		},3000);*/
		$("input[type=text]").bind('keyup change input', function () {
			sendRequest();
		});

		$("select").bind('keyup change input', function () {
			sendRequest();
		});

		$("input[type=text]").bind('keyup change input', function () {
			sendRequest_oferta();
		});

		$("select").bind('keyup change input', function () {
			sendRequest_oferta();
		});
		
		function sendRequest(){
			$('#filter-form').ajaxSubmit({
				data:{'pages/produtos.php':$('[name=categoria_id]').val()},
				success:function(data){
					$('.lista-items').html(data);
				}
			})

			
	
			/*$('form').ajaxSubmit({
				data:{'nome_imovel':$('input[name=texto-busca]').val()},
				success:function(data){
					$('.lista-produtos .container').html(data);
				}
			})*/
		}  
		function sendRequest_oferta(){
			$('#filter-form-oferta').ajaxSubmit({
				data:{'pages/oferta.php':$('').val()},
				success:function(data){
					$('#oferta').html(data);
				}
			}); 
		}
		
	});
	