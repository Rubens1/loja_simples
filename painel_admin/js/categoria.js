$(function(){
	$('#id_categoria').change(function(){
		if($(this).val() ) {
			$('#subcategoria_id').hide();
			$.getJSON('ajax/subcategoria.php?search=',{id_categoria: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">Selecione a subcategoria</option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
				}	
				$('#subcategoria_id').html(options).show();
			});
		} else {
			$('#subcategoria_id').html('<option value="">Selecione a subcategoria</option>');
		}
	});
});