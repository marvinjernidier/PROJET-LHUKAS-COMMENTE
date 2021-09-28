<?php
require_once('../bd/connect.php');

//Récupération des variables envoyé grace au formulaires.
$Mail = $_REQUEST["mail"];
$Password = $_REQUEST["mdp"];

//Initialisation des booléens qui serviront a savoir si on a trouvé le mail et le mdp.
$foundMail = false;
$foundPassword = false;


    
//Block de code qui sert a trouvé le mail et le mot de passe correspondant a celui-ci dans la base de données et changé les booléens si besoins.
$searchMail="SELECT mail FROM educ";
$p1 = $co->query($searchMail);

	while ($row = $p1->fetch_assoc() )  
	{
        if($row['mail'] == $Mail) {
            $foundMail = true;
        }
	}

$searchPassword="SELECT * FROM educ WHERE mail='$Mail'";
$p2 = $co->query($searchPassword);

    while ($row2 = $p2->fetch_assoc() )    
        {
            if($row2['password'] == $Password) {
                $foundPassword = true;
                $ID =$row2['IDeduc'];
            }
    
        }


        if($foundMail && $foundPassword) 
        {         
            echo $ID;
        }
        else{

            echo "error";
        }
    ?>
