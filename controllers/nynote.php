<?php
include "../functions/CallAPI.php";
//TODO test når webservice er funktionel og ikke sender xml

if (isset($_POST['NoteSubmit'])){
    $Data = array("Titel"=>$_POST['CreateNoteTitel'],"Note"=>$_POST['CreateNoteNote']);
    $Data = json_encode($Data);
    $result = CallAPI("POST","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note",$Data);
}
if (isset($_POST['UpdateNoteSubmit'])){
    $Data = array("Id"=>$_POST['UpdateNoteId'],"Titel"=>$_POST['CreateNoteTitel'],"Note"=>$_POST['CreateNoteNote']);
    $Data = json_encode($Data);
    $result = CallAPI("PUT","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note/".$_POST['UpdateNoteId'],$Data);
}

require_once '../vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('nynote.html.twig');
$parametersToTwig = array();
echo $template->render($parametersToTwig);