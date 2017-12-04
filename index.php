<?php

$Opskrifter = "";
$Noter = "";
function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data))
            );
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

$ForeCast = simplexml_load_file("http://www.yr.no/place/Denmark/Zealand/Roskilde/forecast_hour_by_hour.xml");
//var_dump ($ForeCast->forecast->tabular->time);
//$NextForeCast = $ForeCast->forecast->tabular->time;
$NextForeCast = $ForeCast->forecast->tabular->time;

$WeatherSymbolName = $NextForeCast[0]->symbol->attributes()["name"];
$WeatherTemperature = $NextForeCast[0]->temperature->attributes()["value"];
$TemperatureUnit = $NextForeCast[0]->temperature->attributes()["unit"];
date_default_timezone_set("Europe/Copenhagen");
$date = date("H:i");

$lokaltemperaturdata = file_get_contents("http://coolscreenwebservice.azurewebsites.net/Service1.svc/Temperatur");
$lokaltemperatur = json_decode($lokaltemperaturdata,true);
//$lokaltemperatur = array($lokaltemperatur);

if (isset($_POST['GetOpskriftKnap'])&!empty($_POST['GetOpskriftIdFelt'])){
    $uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter" . $_POST['GetOpskriftIdFelt'];
    $jsondata = file_get_contents($uri);
    $convertToAssociativeArray = true;
    $Opskrifter = json_decode($jsondata, $convertToAssociativeArray);
    $Opskrifter = array($Opskrifter);
}
/*flyttet til sin egen side
elseif (isset($_POST['GetOpskriftKnap'])){
    $uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter";
    $jsondata = file_get_contents($uri);
    $convertToAssociativeArray = true;
    $Opskrifter = json_decode($jsondata, $convertToAssociativeArray);
}*/

if (isset($_POST['CreatueOpskriftSubmit'])){
    $Data = array("Titel"=>$_POST['CreateOpskriftTitel'],"Ingredienser"=>$_POST['CreateOpskriftIngredienser'],"Opskrift"=>$_POST['CreateOpskrift']);
    $Data = json_encode($Data);
    $result = CallAPI("POST","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter",$Data);
}
if (isset($_POST['UpdateCustomerSubmit'])){
    $Data = array("Id"=>$_POST['UpdateOpskriftId'],"Titel"=>$_POST['CreateOpskriftTitel'],"Ingredienser"=>$_POST['CreateOpskriftIngredienser'],"Opskrift"=>$_POST['CreateOpskrift']);
    $Data = json_encode($Data);
    $result = CallAPI("PUT","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter",$Data);
}
if (isset($_POST['DeleteOpskriftSubmit'])){
   // $data = array("Id"=>$_POST['DeleteOpskriftId']);
    //$data = json_encode($data);
   // $result = CallAPI("DELETE","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter/".$_POST['DeleteOpskriftId']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter/".$_POST['DeleteOpskriftId']);
    $result = curl_exec($curl);
    curl_close($curl);
}
//NOTER
if (isset($_POST['GetNoteKnap'])){
    $uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Noter";
    $jsondata = file_get_contents($uri);
    $convertToAssociativeArray = true;
    $Noter = json_decode($jsondata, $convertToAssociativeArray);
}
//TODO Test når webserive er funktionel
if (isset($_POST['NoteSubmit'])){
    $Data = array("Titel"=>$_POST['CreateNoteTitel'],"Note"=>$_POST['CreateNoteNote']);
    $Data = json_encode($Data);
    $result = CallAPI("POST","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Noter",$Data);
}
if (isset($_POST['UpdateNoteSubmit'])){
    $Data = array("Id"=>$_POST['UpdateNoteId'],"Titel"=>$_POST['CreateNoteTitel'],"Note"=>$_POST['CreateNoteNote']);
    $Data = json_encode($Data);
    $result = CallAPI("PUT","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Noter",$Data);
}
if (isset($_POST['DeleteNoteSubmit'])){
    // $data = array("Id"=>$_POST['DeleteOpskriftId']);
    //$data = json_encode($data);
    // $result = CallAPI("DELETE","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter/".$_POST['DeleteOpskriftId']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Noter/".$_POST['DeleteNoteId']);
    $result = curl_exec($curl);
    curl_close($curl);
}



require_once 'vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('index.html.twig');
$parametersToTwig = array("Date"=>$date,"WeatherSymbolName" => $WeatherSymbolName,"WeatherTemperatue" => $WeatherTemperature, "TemperatureUnit" =>$TemperatureUnit, "Opskrifter"=>$Opskrifter,"lokaltemperatur"=>$lokaltemperatur,"Noter"=>$Noter);
echo $template->render($parametersToTwig);

