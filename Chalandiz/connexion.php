<?php
require_once('connect.php');



$foundMail=0;


//Récupération de toutes les variables passé grace au formulaire

$mail = $_GET["mail"];
$mdp = $_GET["mdp"];




$trouvé = false;






//Comparaison avec les mails déja existant avec le mail envoyé depuis le formulaires et si le code parrain entrée est valide pour lui accordée des points supplémentaires.
$sql="SELECT * FROM user";
$p1 = $co->query($sql);
	while ($row = $p1->fetch_assoc() )  
	{
        if($row['mail'] == $mail && $row['mdp'] == $mdp) {
            $trouvé = true;
        }
	}

    echo $trouvé;

    


    
    ?>