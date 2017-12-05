<?php
$Noter = "";
//TODO test når webservice er funktionel og ikke sender xml

$uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note";
$jsondata = file_get_contents($uri);
$convertToAssociativeArray = true;
$Noter = json_decode($jsondata, $convertToAssociativeArray);

if (isset($_POST['DeleteNoteSubmit'])){
    // $data = array("Id"=>$_POST['DeleteOpskriftId']);
    //$data = json_encode($data);
    // $result = CallAPI("DELETE","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter/".$_POST['DeleteOpskriftId']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note/".$_POST['DeleteNoteId']);
    $result = curl_exec($curl);
    curl_close($curl);
}

require_once '../vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('noter.html.twig');
$parametersToTwig = array("Noter" =>$Noter);
echo $template->render($parametersToTwig);