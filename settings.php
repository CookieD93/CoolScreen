<?php


// if(isset($_POST['toggleNews'])){
// 	if(@$_COOKIE["newsWidget"] == "1")
// 	{
// 		setcookie ("newsWidget", "",0);
// 	}else {
// 		setcookie ("newsWidget", "1",time() + (10 * 365 * 24 * 60 * 60));
// 	}
// 	header("location:settings.php");
// }

$newsText = "fra";
// if(isset($_COOKIE['newsWidget']) && ($_COOKIE['newsWidget']=="1")){
// 	$newsText = "til";
// }



function toggleWidget($widgetToToggle){
	if(isset($_COOKIE[$widgetToToggle.'Widget'])){
		setcookie ($widgetToToggle.'Widget', "",0);
	}else {
		setcookie ($widgetToToggle.'Widget', "true",time() + (10 * 365 * 24 * 60 * 60));
	}
	header("location:settings.php");
}

if(isset($_POST['toggleWidget'])){
	toggleWidget($_POST['toggleWidget']);
}
 


$NewsXml = simplexml_load_file("https://www.dr.dk/nyheder/service/feeds/udland");
$NewsXml = $NewsXml->channel->item;

$ForeCast = simplexml_load_file("http://www.yr.no/place/Denmark/Zealand/Roskilde/forecast_hour_by_hour.xml");
$NextForeCast = $ForeCast->forecast->tabular->time;

// $WeatherSymbolName = $NextForeCast[0]->symbol->attributes()["name"];
$WeatherSymbolName = $NextForeCast[0]->symbol->attributes()["var"];
$WeatherTemperature = $NextForeCast[0]->temperature->attributes()["value"];
$TemperatureUnit = $NextForeCast[0]->temperature->attributes()["unit"];
date_default_timezone_set("Europe/Copenhagen");
$date = date("d. M y");

$lokaltemperaturdata = file_get_contents("http://coolscreenwebservice.azurewebsites.net/Service1.svc/Temperatur");
$lokaltemperatur = json_decode($lokaltemperaturdata,true);
//$lokaltemperatur = array($lokaltemperatur);



require_once 'vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('settings.html.twig');
$parametersToTwig = array("newsText"=>$newsText,"cookies"=>$_COOKIE);
echo $template->render($parametersToTwig);

?>
