$(function(){	
    /*
         Auto complemento
   */
 /*
        $('.pesquisa_produto').bind('keyup change input', function (e) {
            e.preventDefault();
            $.ajax({
                url: include_path+'ajax/busca.php',
                data:{pesquisa:$('[name=pesquisa]').val(),autocompletar:'autocompletar'},
                method:'post',success:function(data){
                    $('.container_resultado').html(data);
                }
            })
        });

       
           $("#pesquisa").autocomplete({
                source: function () {
                    $.ajax({
                     url: include_path+"ajax/busca.php",
                     data: {pesquisa: $('[name=pesquisa]').val()},
                     method:'post',success:function(data) {
                         if($('[name=pesquisa]').change().val() != ''){
                            $('.container_resultado').html(data); 
                         }else{
                            $('.container_resultado').html('');
                         }
                     }
                   });
                  
                  },
                minLength: 2
            });*/
            $('#pesquisa').autocomplete({
                source: include_path+'ajax/busca.php',
                minLength: 1,
                select: function(event, ui)
                {
                  $('#pesquisa').val(ui.item.value);
                }
              }).data('ui-autocomplete')._renderItem = function(ul, item){
                return $("<div class='container_resultado'></div>")
                  .data("item.autocomplete", item)
                  .append(item.label)
                  .appendTo(ul);
              };
})
