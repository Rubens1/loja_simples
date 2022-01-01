  var fullImg = document.getElementById("imageBox");
  var fulliframe = document.getElementById("videoBox");
  var fullVideo = document.getElementById("video");
  var zoom = document.getElementById("img-container");

  let thumbnails = document.getElementsByClassName('thumbnail')

  let activeImages = document.getElementsByClassName('active')
    for (var i=0; i < thumbnails.length; i++){
      
      thumbnails[i].addEventListener('click', function(){
        console.log(activeImages)
        
        if (activeImages.length > 0){
          activeImages[0].classList.remove('active')
        }
        this.classList.add('active')
        document.getElementById('imageBox').src = this.src

      })
    }
function produtoDetalhes(smallImg){

  if(smallImg == fullVideo){
      fullImg.style.display = 'none';
      fulliframe.style.display = 'block';
  }else{
      if(smallImg != fullVideo){
          fullImg.style.display = 'block';
      }
      
      fullImg.src = smallImg.src;
      fulliframe.style.display = 'none';
      zoom.style.display = 'none';
  }
 
}

function addZoom(){
  var zoom = document.getElementById("img-container");
   zoom.style.display = 'block';
}
function removeZoom(){
  var zoom = document.getElementById("img-container");
  zoom.style.display = 'none';
}


/*
		Remover letras do campo 
	*/
	$('.numeros-produto').on('keypress', function (event) {
		var regex = new RegExp("^[0-9]+$");
		var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		if (!regex.test(key)) {
		   event.preventDefault();
		   return false;
		}
	});
