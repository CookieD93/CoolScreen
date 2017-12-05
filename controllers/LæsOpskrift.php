<?php

$uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter/" . $_GET['id'];
$jsondata = file_get_contents($uri);
$convertToAssociativeArray = true;
$Opskrifter = json_decode($jsondata, $convertToAssociativeArray);
$Opskrifter = array($Opskrifter);

require_once '../vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('LæsOpskrift.html.twig');
$parametersToTwig = array("Opskrift"=>$Opskrifter);
echo $template->render($parametersToTwig);