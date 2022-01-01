$(() => {
    var spin = '<div class="d-flex justify-content-center spinner" ><div class="spinner-border text-info h1" role="status" style="width:100px;height:100px"><span class="sr-only">Carregando...</span></div></div>';
    var tr = document.createElement('TR');
    var navItem = $('.card-header .nav-item')
    // CARREGA DATAS DOS PEDIDOS 
    $.post('./controllers/cupom.php', {route: 'datas'}, function(dados){
        res = testarJson(dados);
        
        res.forEach((element, index) => {
            data = new Date(element.dataModificado + ' 03:00').toLocaleDateString();
            nNavItem = $(navItem).clone();
            $(nNavItem).removeClass('d-none');
            $(nNavItem).find('.nav-link').attr('data-date', element.dataModificado).text(data);
          
            // ADD FUNCAO CARREGA LISTA AS ABAS DE DATAS
            $(nNavItem).click(function(){
                data = $(this).find('a').attr('data-date');
                carregarLista(data);
                $('.nav-link').removeClass('active');
                $(this).find('a').addClass('active');
            })
            // ADD FUNCAO CARREGA LISTA AS ABAS DE DATAS
            $('.card-header .nav').append(nNavItem);
        })
        carregarLista(res[0].dataModificado)
        $('.card-header .nav-item').eq(1).find('a').addClass('active');
    })
    // CARREGA DATAS DOS PEDIDOS 



    // CARREGA LISTA DE PEDIDOS
    function carregarLista(data) {
        $('.container .card-body').append(spin)
        $('tbody').html('')
        $.post('./controllers/cupom.php', {route: 'listar-pedidos', data:data}, function(dados){
            $('.container .card-body .spinner').remove();
            var res = testarJson(dados);
            res.forEach((element, index) => {
                var ntr = $(tr).clone().addClass('text-center');
                var cupom = element.cupom == null ? '' : element.cupom;
                

                $(ntr).append(  '<td>'+ element.idPedido +'</td>'+
                                '<td>'+ element.cliente  +'</td>'+
                                '<td class="cupom">'+ cupom +'</td>'+
                                '<td class="enviarEmail"></td>'+
                                '<td class="gerar"></td>')

                if(element.cupom == null || element.cupom == 0){
                    var btnGerar = document.createElement('BUTTON')
                    $(btnGerar).text('Gerar').addClass('btn btn-primary').attr({'data-idPedido': element.idPedido, 'data-idCliente': element.idCliente});
                    $(btnGerar).click(function() {
                        var idPedido = $(this).attr('data-idPedido');
                        var idCliente = $(this).attr('data-idCliente');
                        $.post('./controllers/cupom.php', { idPedido, idCliente, route: 'gerar-cupom' }, function(dados) {
                            res = testarJson(dados.split('---')[0]);
                            if(res.resultado == 'ok'){
                                $(ntr).find('.cupom').html(res.cupom);
                                $(ntr).find('.gerar').find('button').addClass('d-none');
                                $(ntr).find('.enviarEmail').find('button').attr('data-cupom', res.cupom).removeClass('d-none');
                                chamarAlerta(res);
                            } else {
                                chamarAlerta(res);
                            }                                                       
                        })
                    })
                    $(ntr).find('.gerar').append(btnGerar);
                } 

                // cria btn enviar Email
                var btnEmail = document.createElement('BUTTON');
                $(btnEmail).text('Reenviar').addClass('btn btn-secondary').attr({'data-idCliente': element.idCliente, 'data-cupom': element.cupom});
                if(element.cupom == null || element.cupom == ''){ $(btnEmail).addClass('d-none'); }
            
                // funcao click btn enviou 
                $(btnEmail).click(function(){
                    var idCliente = $(this).attr('data-idCliente');
                    var cupom = $(this).attr('data-cupom');
                    $.post('./controllers/cupom.php', {route:'reenviar-email', idCliente, cupom }, function(dados){
                        res = testarJson(dados.replace('---', ''))
                        chamarAlerta(res)
                    })
                })
                // funcao click btn enviou 

                $(ntr).find('.enviarEmail').html(btnEmail)
                // cria btn enviou



                $('tbody').append(ntr)
                
            })
        })
    }
    // CARREGA LISTA DE PEDIDOS


})