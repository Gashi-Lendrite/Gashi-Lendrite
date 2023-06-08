<?php
if(isset($_GET['page']))
{
	$page = $_GET['page'];
	if($page == "importergraphe")
	{
		$titre = "Importer le graphe du bâtiment au format XGML";
		$contenu = 'upload_graphe.php';
	}
	else if($page == "superviserbornes")
	{
		$titre = "Superviser les bornes";		
		$contenu = 'superviser_bornes.php';
	}
}
		else

{
	$titre = "Administrateur";
	$contenu = 'administrateur.html';
}

include("retour.php");
include($contenu);
include("bas.html");

?>