<?php
$uri = "http://coolscreenwebservice.azurewebsites.net/Service1.svc/Opskrifter";
$jsondata = file_get_contents($uri);
$convertToAssociativeArray = true;
$Opskrifter = json_decode($jsondata, $convertToAssociativeArray);