<?php

$Opskrifter = "";
$Noter = "";



$NewsXml = simplexml_load_file("https://www.dr.dk/nyheder/service/feeds/allenyheder");
$NewsXml = $NewsXml->channel->item;



$ForeCast = simplexml_load_file("http://www.yr.no/place/Denmark/Zealand/Roskilde/forecast_hour_by_hour.xml");
$NextForeCast = $ForeCast->forecast->tabular->time;
$weatherDescriptionArray = array(

	"1"=>"Klar himmel",
	"2"=>"Let skyet",
	"3"=>"Delvis skyet",
	"4"=>"Skyet",
	"40"=>"Lette regnbyger",
	"5"=>"Regnbyger",
	"41"=>"Kraftige regnbyger",
	"24"=>"Lette regnbyger og torden",
	"6"=>"Regnbyger og torden",
	"25"=>"Kraftige regnbyger",
	"42"=>"Lette sludbyger",
	"7"=>"Sludbyger",
	"43"=>"Kraftige sludbyger",
	"26"=>"Lette sludbyger og torden",
	"20"=>"Sludbyger og torden",
	"27"=>"Kraftige sludbyger og torden",
	"44"=>"Lette snebyger",
	"8"=>"Snebyger",
	"45"=>"Kraftige snebyger",
	"28"=>"Lette snebyger og torden",
	"21"=>"Snebyger og torden",
	"29"=>"Kraftig snebyger og torden",
	"46"=>"Let regn",
	"9"=>"Regn",
	"10"=>"Kraftig regn",
	"30"=>"Let regn og torden",
	"22"=>"Regn og torden",
	"11"=>"Kraftig regn og Torden",
	"47"=>"Let slud",
	"12"=>"Slud",
	"48"=>"Kraftig slud",
	"31"=>"Let slud og torden",
	"23"=>"Slud og torden",
	"32"=>"Kraftig slud og torden",
	"49"=>"Let sne",
	"13"=>"Sne",
	"50"=>"Kraftig sne",
	"33"=>"Let sne og torden",
	"14"=>"Sne og torden",
	"34"=>"Kraftig sne og torden",
	"15"=>"Tåget"

);

$WeatherSymbolName = $NextForeCast[0]->symbol->attributes()["name"];
$WeatherSymbolNumber = $NextForeCast[0]->symbol->attributes()["number"];
$weatherDescription = $weatherDescriptionArray[trim($WeatherSymbolNumber)];
$WeatherSymbolVar = $NextForeCast[0]->symbol->attributes()["var"];
$WeatherTemperature = $NextForeCast[0]->temperature->attributes()["value"];
$TemperatureUnit = $NextForeCast[0]->temperature->attributes()["unit"];
date_default_timezone_set("Europe/Copenhagen");
$date = date("d. M y");

$lokaltemperaturdata = file_get_contents("http://coolscreenwebservice.azurewebsites.net/Service1.svc/Temperatur");
$lokaltemperatur = json_decode($lokaltemperaturdata,true);
//$lokaltemperatur = array($lokaltemperatur);

//Henter en opskrift med det bestemte ID
if (isset($_POST['GetOpskriftKnap'])&!empty($_POST['GetOpskriftIdFelt'])){
    $uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter" . $_POST['GetOpskriftIdFelt'];
    $jsondata = file_get_contents($uri);
    $convertToAssociativeArray = true;
    $Opskrifter = json_decode($jsondata, $convertToAssociativeArray);
    $Opskrifter = array($Opskrifter);
}


require_once 'vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('index.html.twig');
$parametersToTwig = array("Date"=>$date,"WeatherSymbolVar"=>$WeatherSymbolVar,"WeatherSymbolName" => $WeatherSymbolName,"WeatherTemperatue" => $WeatherTemperature, "TemperatureUnit" =>$TemperatureUnit, "Opskrifter"=>$Opskrifter,"lokaltemperatur"=>$lokaltemperatur,"Noter"=>$Noter, "NewsXml"=>$NewsXml,"cookies"=>$_COOKIE,"weatherDescription"=>$weatherDescription);
echo $template->render($parametersToTwig);

?>
