$(function(){
$(document).ready(function() {
    $(".hamburguer").click(function () {
      $(this).toggleClass("hamburguer-active");
      $(".nav-list-mobile").toggleClass("active");
    });
  });

  $('.info .user-view').click(function(){
		var listaMenuCliente = $('ul.cliente');

		if(listaMenuCliente.is(':hidden') == true){
			listaMenuCliente.slideToggle();
		}
		else{
			listaMenuCliente.slideToggle();
		}

	});

})