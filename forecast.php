<?php 
// Получение данных о погоде из БД
function getDbForecast($city, $link){
	$start = date('Y-m-d H:i:s', time() - 24*60*60);
	$result = mysqli_query($link, "SELECT date_query AS x , temp AS y FROM `temp_data` WHERE `city` = '".$city."' and `date_query` > '".$start."' ORDER BY 'date_query'");
	$tempData = mysqli_fetch_all($result, MYSQLI_ASSOC);
	for ($i = 0; $i < count($tempData); $i++){
		$tempData[$i]['y'] = (double)str_replace(',','.',$tempData[$i]['y']);
	}
	return json_encode($tempData);
}

//Получение данных о погоде с сервера
function getWebForecast($name, $gorod) {
	$opts = array(
	  'http'=>array(
		'method'  => 'POST',
		'header'  => 'Content-Type: application/json',
		'content' => '{
				"method": "getForecast",
				"params": [ "'. $name.'", "'.$gorod. '"]
			}'
	  )
	);
	$context = stream_context_create($opts);
	try {
		$getForecastData = file_get_contents('http://pogoda.ngs.ru/json/', false, $context);
		$resultData = json_decode($getForecastData);
		return json_encode($resultData->result);
	}
	catch (Exception $e) {
		return 'Error';
	}
}

//Запись данных о погоде в БД
function addForecast($link){
	$cities = array('krsk','nsk','kemerovo');
	foreach ($cities as $city) {
		$forecast = json_decode(getWebForecast('current',  $city), true);
		$result = mysqli_query($link, "INSERT INTO `temp_data`(`date_query`, `temp`,`city`)
								VALUES ('".date('Y-m-d H:i:s')."','".$forecast['temp_current_c']."','".$city."')");
	}
}

// Подключеие к БД
$db_host='localhost';
$db_name='forecast';
$db_user='root';
$db_pass='';
$link = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (isset($_POST['gorod']) and !empty($_POST['gorod'])){
	echo json_encode(array(getWebForecast('current',$_POST['gorod']),getDbForecast($_POST['gorod'], $link)));
} else {
	addForecast($link);
}