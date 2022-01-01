    
    /*
        Carregamento de paginas
    */
        function carregar(inicio, max, url,pagina){    
            $.ajax({
                url: url,
                data:{inicio : inicio, max : max,pagina:pagina},
                method:'post',success: function(data){
                    $(".resposta .info_painel").last().remove();
                    var conta = $(".info_painel .coluna_info_painel").length;
                    for(i = 0; i < 1; i++){
                        $(".resposta").append(data)
                    }
                    if(conta == data.length){
                        $(".botao_mais").hide();
                    }  
                }
            });
        }
    
        /*
            Rota/Pagina do corpo do site "Ver onde o usuario esta dentro do sistema"
        */
        var pagina = $('body').attr('pagina');
    
    
        /*
            Url do site
        */
            var include_path = $('base').attr('base');
    
        /*
            Remover letras do campo 
        */
        $('.numeros').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
               event.preventDefault();
               return false;
            }
        });
    
    
       