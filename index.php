 <?php



$ForeCast = simplexml_load_file("http://www.yr.no/place/Denmark/Zealand/Roskilde/forecast_hour_by_hour.xml");
//var_dump ($ForeCast->forecast->tabular->time);
//$NextForeCast = $ForeCast->forecast->tabular->time;
$NextForeCast = $ForeCast->forecast->tabular->time;

$WeatherSymbolName = $NextForeCast[0]->symbol->attributes()["name"];
$WeatherTemperature = $NextForeCast[0]->temperature->attributes()["value"];
$TemperatureUnit = $NextForeCast[0]->temperature->attributes()["unit"];
 date_default_timezone_set("Europe/Copenhagen");
 $date = date("H:i");


 require_once 'vendor/autoload.php';
 Twig_Autoloader::register();
 $loader = new Twig_Loader_Filesystem('views');
 $twig = new Twig_Environment($loader, array(
     'auto_reload' => true
 ));
 $template = $twig->loadTemplate('index.html.twig');
 $parametersToTwig = array("Date"=>$date,"WeatherSymbolName" => $WeatherSymbolName,"WeatherTemperatue" => $WeatherTemperature, "TemperatureUnit" =>$TemperatureUnit);
 echo $template->render($parametersToTwig);

