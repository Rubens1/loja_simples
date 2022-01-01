$(function(){
    var url = 'ajax/contabilidade.php';
    
	$('[name=tipo]').change(function(){
		var val = $(this).val();
		if(val == 'funcionario'){
			$('[name=funcionario_conta]').parent().show();
			$('[name=imposto_conta]').parent().hide();
            $('[name=fixo_conta]').parent().hide();
		}else if(val == 'fixo'){
			$('[name=fixo_conta]').parent().show();
			$('[name=funcionario_conta]').parent().hide();
            $('[name=imposto_conta]').parent().hide();
		}else{
            $('[name=imposto_conta]').parent().show();
			$('[name=funcionario_conta]').parent().hide();
            $('[name=fixo_conta]').parent().hide();
        }
	})

    /*
        Atualizar as inforamções da contabilidade
    */
    $('#myProgress').hide();
    $('.contabilidade_atualizar').click(function(e){
        e.preventDefault();
        $('#myProgress').show();
        $.ajax({
			url:url,
			data:{atualizar:'conta atualizada'},
			method:'post',success:function(data){
                var elem = document.getElementById("myBar");  
                var width = 1;
                var percent = Math.round((data.loaded*100)/data.total);

                var id = setInterval(frame, percent);
                function frame(){
                    if(width >= 100){
                        clearInterval(id);
                        $('.resultados').html(data);
                    }else{
                        width++; 
                        elem.style.width = width + '%'; 
                        document.getElementById("label").innerHTML = width * 1  + '%';
                    }
                }
            }
        })
    })

    /*
        Limpa a mensagem de adicionar conta
    */
    $('.add_conta').click(function(e){
        $('.resultado_conta').html('')
    })
    
    /*
        Envia conta para o banco de dados
    */
    $('#form_cadastrar_conta').submit(function(e){
		e.preventDefault();
		       
        $.ajax({
			url:url,
			data:$('#form_cadastrar_conta').serialize(),
			method:'post',success:function(data){
                $('.resultado_conta').html(data)
            }
        })
        
        $('.resultado_conta').html('')
       
	})

    /*
        Enviar a data do gasto da publicidade
    */
    $('.publicidade_click').click(function(e){
        e.preventDefault();
        var publicidade = $(this).attr('publicidade');
        console.log(publicidade);
        document.getElementById("data_publicidade").value = publicidade;
       $('#valor_publicidade').focus()

    })

    /*
        Cadastra o gasto com a publicidade 
    */
    $('#publicidade_envia').submit(function(e){
        e.preventDefault();
       
        $.ajax({
            url:url,
            data:$('#publicidade_envia').serialize(),
            method:'post',success:function(data){
                $('.resposta_publicidade').html(data)
            }
        })

    })
})