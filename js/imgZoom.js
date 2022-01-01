document.getElementById('img').addEventListener('mouseover', function(){
	let w = window.innerWidth;
	var zoom = document.getElementById("img-container");

	window.addEventListener('resize', () =>{
	w = window.innerWidth;
	})
	if(w <= 768){
    zoom.style.display = 'none';
	}
    imageZoom('imageBox')
})

function imageZoom(imgID){
	let img = document.getElementById(imgID)
	let lens = document.getElementById('img-container')

	lens.style.backgroundImage = `url( ${img.src} )`
    lens.style.backgroundRepeat = "no-repeat";
    lens.style.padding = "10px";
	let ratio = 1.89;
    let ratio2 = 2;
	lens.style.backgroundSize = (img.width * ratio) + 'px ' + (img.height * ratio2) + 'px';
	img.addEventListener("mousemove", moveLens)
	lens.addEventListener("mousemove", moveLens)
	img.addEventListener("touchmove", moveLens)
    
	function moveLens(){

		let pos = getCursor()

		let positionLeft = pos.x - (lens.offsetWidth / 2)
		let positionTop = pos.y - (lens.offsetHeight / 2)

		if(positionLeft < 0 ){
			positionLeft = 0
		}

		if(positionTop < 0 ){
			positionTop = 0
		}

		if(positionLeft > img.width - lens.offsetWidth /3 ){
			positionLeft = img.width - lens.offsetWidth /3
		}

		lens.style.backgroundPosition = "-" + (pos.x + ratio) + 'px -' +  (pos.y + ratio) + 'px'
	}

	function getCursor(){

        let e = window.event
        let bounds = img.getBoundingClientRect()

        let x = e.pageX - bounds.left
		let y = e.pageY - bounds.top
		x = x - window.pageXOffset;
		y = y - window.pageYOffset;
		
		return {'x':x, 'y':y}
	}

}

imageZoom('imageBox')
