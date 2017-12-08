<?php
include "functions/CallAPI.php";
//TODO test når webservice er funktionel og ikke sender xml

$addEditFunction = "CreateNoteSubmit";
$addEditTxt = "Tilføj";
$NoteXml ="";

if(isset($_GET['edit'])){
	$addEditFunction = "UpdateNoteSubmit";
	$addEditTxt = "Ret";
	// $NoteXml = simplexml_load_file("http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note/".$_GET['edit']);
	// $NoteXml = $NoteXml;
	// var_dump($NoteXml);


$uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note/".$_GET['edit'];
// $uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note/48";
$jsondata = file_get_contents($uri);
$convertToAssociativeArray = true;
$NoteSingle = json_decode($jsondata, $convertToAssociativeArray);


}




//var_dump ($ForeCast->forecast->tabular->time);
//$NextForeCast = $ForeCast->forecast->tabular->time;



if (isset($_POST['CreateNoteSubmit'])){
    $Data = array("Titel"=>$_POST['CreateNoteTitel'],"Note"=>$_POST['CreateNoteNote']);
    $Data = json_encode($Data);
    $result = CallAPI("POST","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note",$Data);
    header("location:noter.php");
}
if (isset($_POST['UpdateNoteSubmit'])){
    $Data = array("Id"=>$_POST['UpdateNoteId'],"Titel"=>$_POST['CreateNoteTitel'],"Note"=>$_POST['CreateNoteNote']);
    $Data = json_encode($Data);
    // $result = CallAPI("PUT","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note/".$_POST['UpdateNoteId'],$Data);
    $result = CallAPI("PUT","http://coolscreenwebservice.azurewebsites.net/Service1.svc/Note",$Data);
    header("location:note.php?id=$_POST[UpdateNoteId]");
}

require_once 'vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('nynote.html.twig');
$parametersToTwig = array("NoteSingle"=>$NoteSingle, "addEditFunction"=>$addEditFunction, "addEditTxt"=>$addEditTxt);
echo $template->render($parametersToTwig);