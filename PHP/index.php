<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
 <?php
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
var_dump ($ForeCast);
echo "</pre>";


 ?>
</body>
</html>