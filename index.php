<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/xcharts.css" />
	<script src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
	<script src="js/jquery.imagemapster.js" type="text/javascript"></script>
	<script src="js/scripts.js" type="text/javascript"></script>
	<script src="js/d3.min.js" type="text/javascript"></script>
	<script src="js/xcharts.min.js" type="text/javascript"></script>
	<title>Прогноз погоды</title>
	
</head>
<body>
	<div id='container'>
		<div id='logo_box'>
			<span id = 'site_name'>Прогноз погоды</span>
		</div>
		<div id='content'>
			<div id =  "block">
				<img id = "img_map" src ="img/map.png" width="703" height="730" alt="Planets" usemap ="#map" />
				<map id="map" name="map">
					<area shape="rect" alt="Красноярск"  coords="271,498,354,515" href="#" data-key = "krsk"/>
					<area shape="rect" alt="Кемерово"  coords="225,569,290,586" href="#" data-key = "kemerovo" />
					<area shape="rect" alt="Новосибирск"  coords="77,577,164,593" href="#" data-key = "nsk"  />
					<area shape="circle" alt="Красноярск метка"  coords="285,529,8" href="#" data-key = "krsk"  />
					<area shape="circle" alt="Кемерово метка"  coords="214,579,8" href="#" data-key = "kemerovo" />
					<area shape="circle" alt="Новосибирск метка"  coords="177,586,8" href="#"  data-key = "nsk"  />
				</map>
			</div>

			<div id="modal_form">
				<span id="modal_close">X</span>
				<strong>Город: <span id="cityName"></span><br/>
				Температура: <span id="temp_c"></span><br/></strong>
				Давление: <span id="pres"></span><br/>
				Ветер: <span id="wind"></span>
				<figure style="width: 400px; height: 400px;" id="temp_graph"></figure>
			</div>
			<div id="overlay"></div>
		</div>
		<div id="footer"></div>
	</div>
</body>
</html>