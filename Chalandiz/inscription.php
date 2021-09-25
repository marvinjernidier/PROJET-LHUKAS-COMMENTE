<?php
require_once('connect.php');



$foundMail=0;


//Récupération de toutes les variables passé grace au formulaire

$prenom = str_replace(' ', '-',ucwords($_GET["prenom"]));
$nom = str_replace(' ', '-',strtoupper($_GET["nom"]));
$mail = $_GET["mail"];
$mdp = $_GET["mdp"];











//Comparaison avec les mails déja existant avec le mail envoyé depuis le formulaires et si le code parrain entrée est valide pour lui accordée des points supplémentaires.
$sql="SELECT * FROM user";
$p1 = $co->query($sql);
	while ($row = $p1->fetch_assoc() )  
	{
        if($row['mail'] == $mail) {
            echo "error";
            $foundMail = 1;
        }
	}

    if($foundMail == 0) {
        
        //Requète pour l'insertion du trainers
        $req= "INSERT INTO user (idUser,nom,prenom,mail,mdp)
        VALUES (null,'$nom','$prenom','$mail','$mdp')";
        $co->query($req);

        echo "validée";

     
   
    }

    


    
    ?>