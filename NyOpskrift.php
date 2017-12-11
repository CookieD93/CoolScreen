<?php
include "functions/CallAPI.php";

$addEditFunction = "CreatueOpskriftSubmit";
$addEditTxt = "Tilføj";
$opskriftEditArray ="";

if(isset($_GET['edit'])){
	$addEditFunction = "UpdateCustomerSubmit";
	$addEditTxt = "Ret";
	$uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter/" . $_GET['edit'];

	$jsondata = file_get_contents($uri);

	$convertToAssociativeArray = true;
	$opskriftEditArray = json_decode($jsondata, $convertToAssociativeArray);
	// var_dump($opskriftEditArray);
}


if (isset($_POST['CreatueOpskriftSubmit'])){
    $Data = array("Titel"=>$_POST['CreateOpskriftTitel'],"Ingredienser"=>$_POST['CreateOpskriftIngredienser'],"Opskrift"=>$_POST['CreateOpskrift']);
    $Data = json_encode($Data);
    $result = CallAPI("POST","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter",$Data);
    header("location:Opskrifter.php");
}
if (isset($_POST['UpdateCustomerSubmit'])){

    $Data = array("Id"=>$_POST['UpdateOpskriftId'],"Titel"=>$_POST['CreateOpskriftTitel'],"Ingredienser"=>$_POST['CreateOpskriftIngredienser'],"Opskrift"=>$_POST['CreateOpskrift']);
    $Data = json_encode($Data);
    $result = CallAPI("PUT","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter",$Data);
    header("location:visOpskrift.php?id=$_POST[UpdateOpskriftId]");
}

require_once 'vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('NyOpskrift.html.twig');
$parametersToTwig = array("opskriftEditArray"=>$opskriftEditArray, "addEditFunction"=>$addEditFunction, "addEditTxt"=>$addEditTxt);
echo $template->render($parametersToTwig);
