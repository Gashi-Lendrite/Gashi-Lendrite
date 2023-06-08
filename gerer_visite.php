<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Gérer les visites</title>
</head>
<body>
  <form  method="post">
    <label>Choisissez un beacon :</label>
    <select name="id_beacon">
      <?php 
        $beacons = array("001C", "000F", "0053","004F","0035","004B","0028");
        foreach ($beacons as $b) 
        {
          echo "<option value='$b'>$b</option>";
        }
      ?>
    </select>
    <br> 
    <label for="destination">Choisissez une destination :</label>
    <select name="num_borne" id="destination">
      <?php
        $destinations = array(
          "chirurgie vasculaire" => 10,
          "accueil" => 20,
          "Hépato-gastro-entérologie" => 30,
          "chirurgie viscérale" => 40,
          "bureau" => 50,
          "Chirurgie maxilo-faciale" => 60,
          "cantine" => 70,
          "Exploration fonctionnelles" => 80,
          "consultation de neuro-chirugie" => 90
        );

        foreach ($destinations as $d => $id) {
          echo "<option value='$id'>$d</option>";
        }

      ?>
    </select>
    <br>
    <input type="submit" value="Envoyer">
  </form>

  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      include 'param.inc.php';
      $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
      if ($mysqli -> connect_errno) 
      {
        echo "<p>Erreur de connexion : ".$mysqli->connect_error."</p>";
        exit(); 
      } 

      $beacon_result = $_POST['id_beacon'];
      $destinations = $_POST['num_borne'];
      

      $requete = "INSERT INTO Visite (num_borne, id_beacon, date_insertion) VALUES ($destinations, '$beacon_result', NOW())";
      
      if (!$mysqli->query($requete)) {
      echo "<p>";
      } else {
      echo "<br>Insertion réussie<br>";
      }

     
      $mysqli -> close();
    }
  ?>

<h2>Liste des visites :</h2>

<form method="post">
<table>
  <thead>
    <tr>
      <th>destination</th>
      <th>Numéro de beacon</th>
      <th>Date de visite</th>
      <th>Supprimer</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
      if ($mysqli -> connect_errno) {
        echo "<p>Erreur de connexion : ".$mysqli->connect_error."</p>";
        exit();
      }

      $requete = "SELECT Borne.nom,id_beacon,date_insertion FROM Visite JOIN Borne ON Borne.numero = num_borne";
      $resultat = $mysqli -> query($requete);

      if ($resultat -> num_rows == 0) {
        echo "<tr><td colspan='4'>Aucune visite</td></tr>";
      } else {
        while ($visite = $resultat -> fetch_assoc()) {
          echo "<tr>";
          echo "<td>".$visite['nom']."</td>";
          echo "<td>".$visite['id_beacon']."</td>";
          echo "<td>".$visite['date_insertion']."</td>";
          echo "<td><input type='checkbox' name='visite[]' value='".$visite['nom']."'></td>";
          echo "</tr>";
        }
      }
      $mysqli -> close();
    ?>
  </tbody>
</table>
<input type="submit" name="supprimer" value="Supprimer les visites sélectionnées">
</form>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer']) && isset($_POST['visite'])) {
    include 'param.inc.php';
    $mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
    if ($mysqli -> connect_errno) 
    {
      echo "<p>Erreur de connexion : ".$mysqli->connect_error."</p>";
      exit();
    }

    $visitesASupprimer = $_POST['visite'];
    $visitesASupprimer = implode("','", $visitesASupprimer);

    $query = "DELETE Visite FROM Visite JOIN Borne ON Borne.numero = Visite.num_borne WHERE Borne.nom IN  ('$visitesASupprimer')";

    if (!$resultat = $mysqli->query($query)) 
    {
      echo "Erreur de requête : ".$mysqli->error;
      exit();
    }

    echo "<p>Visites supprimées avec succès.</p>";

    $mysqli -> close();
  }
?>


</body>
</html>