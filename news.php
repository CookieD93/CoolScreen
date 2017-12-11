<?php


$newsFrom = "Alle Nyheder";
$NewsXml = simplexml_load_file("https://www.dr.dk/nyheder/service/feeds/allenyheder");
if(isset($_GET['n'])){
	$NewsXml = simplexml_load_file("https://www.dr.dk/nyheder/service/feeds/".$_GET['n']);
	$newsFrom = ucfirst($_GET['n']);
	if($newsFrom == "Allenyheder") {
		$newsFrom = "Alle Nyheder";
	}
}
$NewsXml = $NewsXml->channel->item;



require_once 'vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('news.html.twig');
$parametersToTwig = array("NewsXml"=>$NewsXml, "newsFrom"=>$newsFrom);
echo $template->render($parametersToTwig);

?>
