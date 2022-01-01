$(function(){ 

    $('.abrirmodal').click(function(e){
        e.preventDefault();
        var abrirmodal = $(this).attr("abrirmodal");
            document.getElementById('modal_' + abrirmodal).style.top = "0";
            $('.close').click(function(e){
                e.preventDefault()
                document.getElementById('modal_' + abrirmodal).style.top = "-100%";
                
            })
    })
  
})