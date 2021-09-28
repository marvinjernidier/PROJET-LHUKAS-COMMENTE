<?php
require_once('../bd/connect.php');

//Déclaration de certaines variables
$foundMail = 0;


//Récupération de toutes les variables passé grace au formulaire

$FirstName = ucwords($_POST["FirstName"]);
$Surname = strtoupper($_POST["Surname"]);
$Mail = $_POST["Mail"];
$Phone = $_POST["prefix"].$_POST["Phone"];
$Password = $_POST["Password"];
$Poste = $_POST["Poste"];



//Comparaison avec les mails déja existant avec le mail envoyé depuis le formulaires
$sql="SELECT * FROM educ";
$p1 = $co->query($sql);
	while ($row = $p1->fetch_assoc() )  
	{
        if($row['mail'] == $Mail) {
            $foundMail = 3;
        }
	}


   
    if($foundMail == 0) {

         //Requète pour l'insertion dans la base de donnée
        $req= "INSERT INTO educ (IDeduc,FirstName,Surname,mail,password,Phone,poste)
        VALUES (null,'$FirstName','$Surname','$Mail','$Password','$Phone','$Poste')";
        $co->query($req);

        //Récuperation du dernier ID inserée
        $IDnewEDUC = $co->insert_id;

        $foundMail = 2;

        // Synthaxe imposée par SUNSMS pour un envoie de message

        $connection = fopen('https://portal.sunsms.fr/api/1.0/simple/transactional', 'r', false,
        stream_context_create(['http' => [
        'method' => 'POST',
        'header' => [
        'Content-type: application/json'
    ],
        'content' => json_encode([
        'application_id' => '20422',
        'application_token' => 'xYznQHYeRZ9H2NZ1iUu9pAVKURW4pE3FfD2xckbhXtAHZZ3wSI',
        'number' => $row['Phone'],
        'text' => "Voila un lien rapide vers la page administrateur https://chronocoach.fr/vues/admin.php?ID=$IDnewEDUC  , Chronocoach, une solution innovante MJ Metrix",
        'sender_id' => 'gText',
        'sender_id_value' => 'CHRONOCOACH'
    ]),
    'ignore_errors' => true
]])
);

if($connection)
{
$response = json_decode(
    stream_get_contents($connection)
);
var_dump($response);

fclose($connection);
}


    }
header("Location: ../vues/admin.php?ID=$IDnewEDUC"); 

?>

