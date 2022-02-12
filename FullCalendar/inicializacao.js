/*
* Este código JS tem por finalidade executar e iniciar o funcionamento da biblioteca 
* FullCalendar perante aplicação ou seja no documento(página) pois no documento 
* tera de ter um elemento html cujo id seja nomeado com(calendar) para que 
* seja retornado perante este elemento a execução da biblioteca ou seja
* o calendario com seus devidos eventos definidos
* OBS: Para obter dados de eventos dinâmicos diretamente de um banco de dados basta 
* passar o nome do arquivo para o atributo(events). E no arquivo no qual será responsavel
* por selecionar os dados deverá retornar os dados finais no formato json(object) para interpretação
* Author <rogerninopa@gmail.com>

*/
//define codigo javascript executando biblioteca FullCalendar(calendario) após página ser carregada
document.addEventListener("DOMContentLoaded", function(){
	let idCalendar = document.querySelector("#calendar");
	let calendar = new FullCalendar.Calendar(idCalendar, {
		locale:"pt-br",
		plugins:["interaction", "dayGrid"],
		editable:true,
		eventLimit:true,
		events:[
			{
				"title":"Primeiro Evento de teste",
				"color":"#000",
				"start":"2022-02-02 21:00:00",
				"end":"2022-02-02 22:00:00"
			}
		],
		extraParams:function(){
			return {
				cachebuster: new Date().valuOf()
			}
		}
	});
	
	//chamada do método(render()) da class FullCalendar renderizando calendario na pagina em id(calendar)
	calendar.render();
});