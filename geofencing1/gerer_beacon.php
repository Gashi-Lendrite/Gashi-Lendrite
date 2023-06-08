<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Beacons</title>
       <style type="text/css">
           h2, h3, h5, p{
                font-family: Arial, Helvetica, sans-serif;          
            }
            table, th, td {
                border: 2px solid black;
                border-collapse: collapse;
                font-family: Arial, Helvetica, sans-serif; 
            }
            th, td {
                padding: 5px;
            }
           .bouton_croix {
             background: url("croix.jpg");
             width: 20px;
             height: 20px;
             background-repeat: no-repeat;
             border: none;
             cursor: pointer;
           }
        </style>
    </head>
<body>

<?php
// inclure le fichier contenant la fonction
include("fonctions_tableaux.php");
include("param.inc.php");
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli -> connect_errno)
{
   echo "<p>Erreur de connexion : ".$mysqli->connect_error."</p>";
      exit();
}
// ajouter un ami
if(isset($_POST['ajouter']))
{
   $identifiant = $_POST['identifiant'];
   $query = "INSERT INTO Beacon (identifiant) VALUES ('$identifiant')";
   if(!$resultat = $mysqli->query($query))
   {
      echo "Erreur de requête : ".$mysqli->error;
      exit();
   }
}

// supprimer tous les beacons
if(isset($_POST['vider']))
{
   $query = "DELETE FROM Beacon";
   if(!$resultat = $mysqli->query($query))
   {
      echo "Erreur de requête : ".$mysqli->error;
      exit();
   }
}

// supprimer un beacon
if(isset($_POST['supprimer']) && isset($_POST['identifiant']))
{
   $identifiant = $_POST['identifiant'];
   $query = "DELETE FROM Beacon WHERE identifiant='$identifiant'";
   if(!$resultat = $mysqli->query($query))
   {
      echo "Erreur de requête : ".$mysqli->error;
      exit();
   }
}

// formulaire pour ajouter un beacon
echo "<p><form method='post'>";
echo "<h3>Ajouter un beacon</h3>";
echo "<p>identifiant : <input type='text' size='10' maxlength='40' name='identifiant' /></p>";
echo "<p><input type='submit' name='ajouter' value='Ajouter le beacon' /></p>";
echo "</form></p>";


// afficher le tableau des beacons
$query = "SELECT identifiant FROM Beacon ORDER BY identifiant";
if($resultat = $mysqli->query($query))
{
   // tableau PHP contenant les en-têtes de colonnes
   $entetes = ["identifiant", "Supprimer"];
   // tableau des beacons
   $donnees = array();
   // pour chaque enregistrement
   while($ligne = $resultat->fetch_assoc()) 
   {
      $identifiant = $ligne['identifiant'];
      $formulaire_supprimer = "<form method='post'><input type='submit' class='bouton_croix' onclick=\"if(!confirm('Voulez-vous supprimer le beacon $identifiant ?')) return false;\"  name='supprimer' value='' /><input type='hidden' name='identifiant' value='$identifiant'></form>";
      $donnees[] = [$identifiant, $formulaire_supprimer];
   }
   $resultat->free();
   echo "<hr style='border-top:1px dotted #000;'' />";
   echo "<h3>Beacons enregistrés</h3>";
   AfficherTableau($entetes, $donnees, $centrer=true);

   echo "<p><form method='post'>";
   echo "<input type='submit' name='vider' onclick=\"if(!confirm('Voulez-vous supprimer tous les beacons ?')) return false;\" value='Supprimer tous les beacons' />";
   echo "</form></p>";
}
else
   echo "Erreur de requête : ".$mysqli->error;

$mysqli->close();
?>

</body>
</html>