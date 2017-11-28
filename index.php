<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
</head>
<body>
 <?php
 date_default_timezone_set("Europe/Copenhagen");
 echo date("H:i");


/*$BaseUri ="http://www.yr.no/place/Denmark/Zealand/Roskilde/forecast_hour_by_hour.xml";
$ForeCast = ""


$uri= $BaseUri;
$xmlData = file_get_contents($uri);
$convertToAssociativeArray = true;
$ForeCast =
*/

$ForeCast = simplexml_load_file("http://www.yr.no/place/Denmark/Zealand/Roskilde/forecast_hour_by_hour.xml");
echo "<pre>";
//var_dump ($ForeCast->forecast->tabular->time);
//$NextForeCast = $ForeCast->forecast->tabular->time;
$NextForeCast = $ForeCast->forecast->tabular->time;

echo $NextForeCast[0]->symbol->attributes()["name"]."</br>";
echo $NextForeCast[0]->temperature->attributes()["value"]."&deg; ";
echo $NextForeCast[0]->temperature->attributes()["unit"];
 echo "</pre>";

 ?>
</body>
</html>
