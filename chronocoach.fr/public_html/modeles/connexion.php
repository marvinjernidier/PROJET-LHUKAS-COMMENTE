<?php
require_once('../bd/connect.php');

//Récupération des variables envoyé grace au formulaires.
$Mail = $_REQUEST["mail"];
$Password = $_REQUEST["mdp"];


//Initialisation des booléens qui serviront a savoir si on a trouvé le mail, le mdp et pour savoir si il y a déja un utilisateur connecté sur le navigateur.
$otherUserConnect = false;
$foundMail = false;
$foundPassword = false;

//Block de code qui sert a trouvé le mail et le mot de passe correspondant a celui-ci dans la base de données et changé les booléens si besoins.
$searchMail="SELECT Mail FROM trainers";
$p1 = $co->query($searchMail);

	while ($row = $p1->fetch_assoc() )  
	{
        if($row['Mail'] == $Mail) {
            $foundMail = true;
        }
	}

    $searchPassword="SELECT * FROM trainers WHERE Mail='$Mail'";
    $p2 = $co->query($searchPassword);

       while ($row2 = $p2->fetch_assoc() )  
        {
            if($row2['Password'] == $Password) {
                $foundPassword = true;
                $ID = $row2['IDtrainers'];
                
            }
        }


        if($foundMail && $foundPassword) {
            session_start();
           /* if(isset($_SESSION["IDtrainers"])){
                $otherUserConnect = true;
              }
              else{*/
            $_SESSION["IDtrainers"]=$ID;        
           echo $ID;
              //}
            
        
        }
        else{

            echo "error";
        }
    ?>
