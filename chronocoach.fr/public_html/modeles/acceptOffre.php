<?php

require_once('../bd/connect.php');


//Lancement session pour récuperer valeur sessions
session_start();
$IDtrainers = $_SESSION["IDtrainers"];

//requète pour ce connecter a la base de donnée et récuperer les informations de l'educateurs (trainers)
$sql = "SELECT * FROM trainers WHERE IDtrainers='$IDtrainers'";
$p1 = $co->query($sql);
echo $co->error;

while ($row = $p1->fetch_assoc()) {
  $FirstName = $row['FirstName'];
  $Surname = $row['Surname'];
  $point = $row["point"];
}



$nbOffers = $_POST["nbOffers"];

// Vu que les offres on été passé sous forme de formulaire dynamique de ce faite on les récupaire également de manière dynamique.
for($i=1;$i<=10;$i++){


if (isset($_POST["Offers".$i]))
{
$ID = $_POST["Offers".$i];
$seconde = $_POST["seconde".$i];
$subject = $_POST["Subject".$i];
echo $ID.'-';
echo $seconde.'-';
echo $subject;
echo'<br>';


// si l'offre est une sous-offres vérifié avec la conditions si dessous elle possède un traitement spéciale car l'offre principale et les sous-offres sont séparée
    if($seconde == 1)
{
    $sql2 = "UPDATE offerssecond SET Status = 'treaty', IDtrainers = $IDtrainers  WHERE IDofferSeconde = $ID";
    $p2 = $co->query($sql2);
    echo $co->error;


    // récupération des informations importantes de l'offre
    $sql = "SELECT * FROM offerssecond WHERE IDofferSeconde = $ID";
    $p1 = $co->query($sql);
    echo $co->error;
// On récupere ces donnée pour l'envoie de sms plus tard
    while ($row = $p1->fetch_assoc()) {
        $Formation = $row['Formation'];
        $Date = $row['date'];
        $Hour = $row['Hour'];
        $Minute = $row['Minutes'];
    }

} 
else{

    // si elle ne sont pas des sous-offres elle sont des offres principales du coup on les traite comme t'elle
    $sql = "UPDATE offers SET Status = 'treaty', IDtrainers = $IDtrainers  WHERE IDoffers = $ID";
    $p1 = $co->query($sql);
    echo $co->error;
  // récupération des informations importantes de l'offre
    $sql = "SELECT * FROM offers WHERE IDoffers = $ID";
    $p1 = $co->query($sql);
    echo $co->error;
// On récupere ces donnée pour l'envoie de sms plus tard
    while ($row = $p1->fetch_assoc()) {
        $Formation = $row['nameFormation'];
        $Date = $row['date'];
        $Hour = $row['Hour'];
        $Minute = $row['Minutes'];
    }
}

// récupération des donnée de l'equipe formateur (EDUC)
$sql4 = "SELECT * FROM educ";
$p4 = $co->query($sql4);
while ($row4 = $p4->fetch_assoc()) {


//Syntaxe défini par SUNSMS pour envoyé un message
$connection = fopen('https://portal.sunsms.fr/api/1.0/simple/transactional', 'r', false,
    stream_context_create(['http' => [
    'method' => 'POST',
    'header' => [
        'Content-type: application/json'
    ],
    'content' => json_encode([
        'application_id' => '20630',
        'application_token' => 'lZSkQqBi1UmSmKjeLc4mtF4oyWGhJ2ODjJTZg6JJ9YxFZGN33T',
        'number' => $row4['Phone'],
        'text' => "Le formateur $Surname $FirstName a accepté la mission de $subject du $Date a $Hour h $Minute pour la classe $Formation, Chronocoach, une solution innovante MJ Metrix",
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

$point +=10;



}





  
}




//mise a jour des point du formateurs +10 point a chaque missions accepté
$sql = "UPDATE trainers SET point = $point  WHERE IDtrainers = $IDtrainers";
$p1 = $co->query($sql);
















header("Location: ../vues/membre.php");







?>

