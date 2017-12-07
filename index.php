<?php

$Opskrifter = "";
$Noter = "";

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

//Henter en opskrift med det bestemte ID
if (isset($_POST['GetOpskriftKnap'])&!empty($_POST['GetOpskriftIdFelt'])){
    $uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter" . $_POST['GetOpskriftIdFelt'];
    $jsondata = file_get_contents($uri);
    $convertToAssociativeArray = true;
    $Opskrifter = json_decode($jsondata, $convertToAssociativeArray);
    $Opskrifter = array($Opskrifter);
}
$imagenocache="cam.jpg?".filemtime('cam.jpg');

require_once 'vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('index.html.twig');
$parametersToTwig = array("imagenocache"=>$imagenocache,"Date"=>$date,"WeatherSymbolName" => $WeatherSymbolName,"WeatherTemperatue" => $WeatherTemperature, "TemperatureUnit" =>$TemperatureUnit, "Opskrifter"=>$Opskrifter,"lokaltemperatur"=>$lokaltemperatur,"Noter"=>$Noter);
echo $template->render($parametersToTwig);

?>
