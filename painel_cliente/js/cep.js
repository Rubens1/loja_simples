$(function(){
    $('[name=cep]').mask('99999-999');
    
    $("#enderecoForm").on("change", function(e){
        if (e.keyCode == 13) {
            $("#enderecoForm").attr('value');
            return false;
        }
        var numCep = $("#cep").val();
        var url = "https://viacep.com.br/ws/"+numCep+"/json";
       
        $.ajax({
            url: url,
            type: "get",
            dataType: "json",

            success:function(dados){
                $("#uf").val(dados.uf);
                $("#cidade").val(dados.localidade);
                $("#logradouro").val(dados.logradouro);
                $("#bairro").val(dados.bairro);
            }
        })

    }) 
        if($("#cep").val() != ''){
            var numCep = $("#cep").val();
            var url = "https://viacep.com.br/ws/"+numCep+"/json";
           
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
    
                success:function(dados){
                    $("#uf").val(dados.uf);
                    $("#cidade").val(dados.localidade);
                    $("#logradouro").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                }
            })
        }
})
