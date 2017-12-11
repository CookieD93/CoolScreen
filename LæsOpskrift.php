<?php

$uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter/" . $_GET['id'];
$jsondata = file_get_contents($uri);
$convertToAssociativeArray = true;
$Opskrifter = json_decode($jsondata, $convertToAssociativeArray);
$Opskrifter = array($Opskrifter);

if (isset($_POST['DeleteOpskriftSubmit'])){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter/".$_POST['DeleteOpskriftSubmit']);
    $result = curl_exec($curl);
    curl_close($curl);
    header("location:Opskrifter.php");
}


require_once 'vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('LæsOpskrift.html.twig');
$parametersToTwig = array("Opskrift"=>$Opskrifter);
echo $template->render($parametersToTwig);
