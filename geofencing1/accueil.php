<?php
if(isset($_GET['page']))
{
	$page = $_GET['page'];
	if($page == "gererbeacons")
	{
		$titre = "Gérer les beacons";
		$contenu = 'gerer_beacon.php';
	}
	else if($page == "gerervisites")
	{
		$titre = "Gérer les visites";		
		$contenu = 'gerer_visite.php';
	}
	else
	{
		$titre = "Accueil";
		$contenu = 'accueil.html';
	}
}
else
{
	$titre = "Accueil";
	$contenu = 'accueil.html';
}

include("retour.php");
include($contenu);
include("bas.html");
?>
