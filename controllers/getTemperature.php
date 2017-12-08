<?php 


	if($_GET['page'] == "getNow"){
		
		$lokaltemperaturdata = file_get_contents("http://coolscreenwebservice.azurewebsites.net/Service1.svc/Temperatur");
		$lokaltemperatur = json_decode($lokaltemperaturdata,true);
		echo "Køleskab: ".$lokaltemperatur["Temperatur"]."&deg;C";
		if($lokaltemperatur["Temperatur"]>42){
			echo "<div id='alertBox'><i class='fa fa-warning'></i><p>Køleskabet er for varmt!</p></div>";
		}
		
	}
?>