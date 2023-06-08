<?php
    /*include("graphe.class.php");
    include("bddgeofencing.class.php");*/
    if(isset($_POST['envoyer']))
    {
        $file_name = $_FILES["file"]["name"];
        $tmp_name = $_FILES["file"]["tmp_name"];
        $upload_name = "upload/".$file_name;
        $ext = strtolower(pathinfo($file_name)['extension']);
        echo "<p>$upload_name</p>";
        if($ext == "xgml")
        {
            $resultat = move_uploaded_file($tmp_name, $upload_name);
            if($resultat) 
            {
                include ("graphe.php");
                

            }
            else
                echo "<p>Erreur de transfert du fichier !</p>";
		}
        else
        {
        	echo "<h5>Le fichier doit être de type XGML !</h5>";
    		echo file_get_contents("formulaire_graphe.html");
        }
    }
    else
    {
        echo "<h3>Sélectionnez un fichier XGML</h3>";
    	echo file_get_contents("formulaire_graphe.html");
    }
?>
