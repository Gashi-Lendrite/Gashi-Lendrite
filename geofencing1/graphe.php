<?php
include 'param.inc.php';
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli -> connect_errno)
{
   echo "<p>Erreur de connexion : ".$mysqli->connect_error."</p>";
      exit();
}


$xml = simplexml_load_file($upload_name);

if ($xml != false)
	{
	$node = $xml->xpath("/section/section/section[@name='node']/section[@name='LabelGraphics']/attribute[@key='text']");
	$mysqli -> query("DELETE FROM Borne;");
	$i=0;
	$j=0;
	foreach ($node as $n ) 
		{
			
			if (substr($n, 0,4)=="nom=") 
			{
				$nom=substr($n,4);
				$j++;
				
			}
			else if (substr($n, 0,4)=="niv=")
			{
				$niv=substr($n,4);
				$j++;
			}
			else if (substr($n, 0,2)=="x=") 
			{
				$x=substr($n,2);
				$j++;

			}
			else if (substr($n, 0,2)=="y=") 
			{
				$y=substr($n,2);
				$j++;

			}
			else {
				$numero=$n;
				$j++;
			}
			
			if ($j==5)
			{
				
				$requete="INSERT INTO Borne (numero,nom,x,y,N_etage) VALUES ($numero,'$nom',$x,$y,$niv);";
			
				$mysqli -> query($requete);
				$i++;
				$j=0;
			}

		}	
		
	echo "<p>Nombre de bornes : ".$i."</p>";
	
	
	
$edge = $xml->xpath("/section/section/section[@name='edge']/section[@name='LabelGraphics']/attribute[@key='text']");
$les_aretes=array();
$une_arete=array();
$mysqli -> query("DELETE FROM Arete;");
	 
	foreach ($edge as $e) 
		{
			list($b1,$b2,$d,$dire1,$dire2)=explode(",", $e);
			echo "<p>b1:".$b1;
			echo "<p>b2:".$b2;
			echo "<p>distance:".$d;
			echo "<p>direction1:".$dire1;
			echo "<p>diection2:".$dire2;

			$requete="INSERT INTO Arete (Borne_num_1,Borne_num_2,distance_m,dire_1_2,dire_2_1) VALUES($b1,$b2,$d,$dire1,$dire2);";
			
			$mysqli -> query($requete);	

		}
			
	
	$mysqli -> close;	
		
	}else {
		echo "Erreur lors du chargement du fichier xgml";
	}	

?>
