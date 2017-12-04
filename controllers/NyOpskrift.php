<?php
include "../functions/CallAPI.php";

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

require_once '../vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('NyOpskrift.html.twig');
$parametersToTwig = array();
echo $template->render($parametersToTwig);