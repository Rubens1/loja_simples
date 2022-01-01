$('document').ready(function(){
	$.ajax({
		type: "POST",
		url: "ajax/vendas.php",
		dataType: "json",
		success: function(data){
			venda(data);
			//console.log(data);
		}
	});
})

$('document').ready(function(){
    $.ajax({
        type: "POST",
        url: "ajax/publicidade.php",
        dataType: "json",
        success: function(data){
            publicidade(data);
        }
    });
})


$('document').ready(function(){
    $.ajax({
		type: "POST",
		url: "ajax/funcionario.php",
		dataType: "json",
		success: function(data){
            funcionario(data)
        },
    });  
})

function venda(venda){

var vendas_produto= document.getElementById("vendas");
var chart = vendas_produto.getContext('2d');
var vendas_produto = new Chart(chart, {
    type: 'horizontalBar',
    data: {
        labels: venda['nome'],
        datasets: [{
            data: venda['quantidade'],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 0, 255, 0.2)',
                'rgba(122, 96, 40, 0.2)',
                'rgba(40, 100, 122, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 0, 255, 0.2)',
                'rgba(122, 96, 40, 0.2)',
                'rgba(40, 100, 122, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
    	legend: {
            display: false
         },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

}

function publicidade(sistema){

    var publicidade = document.getElementById("publicidade");
    var chart_publicidade = publicidade.getContext('2d');

var publicidade = new Chart(chart_publicidade, {
    type: 'pie',
    data: {
        labels: sistema['meses'],
        datasets: [{
            label: 'Publicidade',
            data: sistema['total'],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(0, 128, 128, 0.2)',
                'rgba(148, 0, 211, 0.2)',
                'rgba(255, 0, 255, 0.2)',
                'rgba(178, 34, 34 0.2)',
                'rgba(32, 250, 185, 0.2)',
                'rgba(20, 195, 253, 0.2)',
                'rgba(122, 96, 40, 0.2)',
                'rgba(122, 11, 91, 0.2)',
                'rgba(40, 100, 122, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(0, 128, 128, 0.2)',
                'rgba(148, 0, 211, 0.2)',
                'rgba(255, 0, 255, 0.2)',
                'rgba(178, 34, 34, 0.2)',
                'rgba(32, 250, 185, 0.2)',
                'rgba(20, 195, 253, 0.2)',
                'rgba(122, 96, 40, 0.2)',
                'rgba(122, 11, 91, 0.2)',
                'rgba(40, 100, 122, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

}



function funcionario(data) {

    var funcionario = document.getElementById("funcionario");
    var chart_funcionario = funcionario.getContext('2d');

    new Chart(chart_funcionario, {
        type: "line",
        data: { 
            labels: data['meses'], 
            datasets: [{ 
                data: data['total'], 
                fill: false, 
                borderColor: "rgb(75, 192, 192)", 
                lineTension: 0.1 
            }] 
        },
        options: {
            legend: {
                display: false
             },
        },
    });
    
}
