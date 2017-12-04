<?php

require_once '../vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, array(
    'auto_reload' => true
));
$template = $twig->loadTemplate('LæsOpskrift.html.twig');
$parametersToTwig = array();
echo $template->render($parametersToTwig);