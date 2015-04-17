jQuery(document).ready(function(){ 
	addDbForecast();
	/* Отмечаем города на карте */
	var image = $('#img_map');
	image.mapster({
		mapKey: 'data-key',
		stroke: true,
		render_highlight: {
			strokeWidth: 2,
			fillOpacity: 0.2
		},
		staticState:false,
		stroke: true, 
	});
	 
	/*Скрипт для окна с наименованием города, температурой и графиком*/
	$('area').click( function(event){ 
		var gorod = $(this).attr('data-key');
		$('#temp_graph').empty();
		event.preventDefault(); 
		switch (gorod) {
		   case 'kemerovo':
			  var cityName = 'Кемерово';
			  break
		   case 'nsk':
			  var cityName = 'Новосибирск';
			  break
		   case 'krsk':
			  var cityName = 'Красноярск';
			  break
		   default:
			  var cityName = 'Город неизвестен';
			  break
		}

		$('#modal_form').find('#cityName').text(cityName);
		$.ajax({
			type: "POST",
			url: "forecast.php",
			data: "&gorod="+gorod,
			success: function(response){
				var forecast = jQuery.parseJSON(response);
				var tempCity = jQuery.parseJSON(forecast[0]);
				console.log(tempCity);
				$('#modal_form').find('#temp_c').text(tempCity['temp_current_c'] + '°C');
				$('#modal_form').find('#pres').text(tempCity['pressure_avg'] + 'мм');
				$('#modal_form').find('#wind').text(tempCity['wind_avg'] + 'м/c');
				//Построение графика
				var dataForecast = jQuery.parseJSON(forecast[1]);
				var data = {
				  "xScale": "ordinal",
				  "yScale": "linear",
				  "type": "line",
				  "main": [
					{
					  "data": dataForecast
					}
				  ]
				};
				var opts = {
				  "dataFormatX": function (x) { return d3.time.format('%Y-%m-%d %X').parse(x); },
				  "tickFormatX": function (x) { return d3.time.format('%H:%M')(x); }
				};
				var myChart = new xChart('line', data, '#temp_graph', opts);
			}
		});

		$('#overlay').fadeIn(400, 
			function(){ 
				$('#modal_form').css('display', 'block').animate({opacity: 1, top: '50%'}, 200); 
		});
	});

	$('#modal_close, #overlay').click( function(){ 
		$('#modal_form')
			.animate({opacity: 0, top: '45%'}, 200,  
				function(){ 
					$(this).css('display', 'none'); 
					$('#overlay').fadeOut(400); 
				}
			);
	});


	var timerId = setInterval(function() {
		addDbForecast();
	}, 300000);

	function addDbForecast(){
		$.ajax({
			url: "forecast.php",
			success: function(){
			}
		});
	}


});