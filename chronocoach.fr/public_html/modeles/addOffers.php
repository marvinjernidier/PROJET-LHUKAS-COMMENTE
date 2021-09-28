<?php
require_once('../bd/connect.php');

$i=1;
$Status = "Untreated";

//Récupératio de toutes les variables passé grace au formulaire

$ID = $_GET["ID"];
$nbNiche = $_POST["nbNiche"];
$Subject = $_POST["Subject"];
$formation = $_POST["formation1"];
$date = $_POST["date1"];
$hour = $_POST["hour1"];
$minutes = $_POST["minutes1"];
$duration = $_POST["duration1"];

if($nbNiche == 1){
    //Requète d'insertions dans la base de donnée de la seule et unique offres posté car nbNiche = 1
    $sql ="INSERT INTO offers (IDoffers, Subject, Duration, Hour, Minutes, date, NameSchool, nameFormation, City, Status, IDtrainers, offersSecond) 
    VALUES (null, '$Subject', '$duration', '$hour', '$minutes', '$date', 'FORE ALTERNANCE', '$formation', 'Baie-Mahault, Guadeloupe', '$Status',0, 0)";
    $co->query($sql);  
}
else {
    // Requète d'insertions dans la base de donnée de l'offres
    $sql ="INSERT INTO offers (IDoffers, Subject, Duration, Hour, Minutes, date, NameSchool, nameFormation, City, Status, IDtrainers, offersSecond) 
    VALUES (null, '$Subject', '$duration', '$hour', '$minutes', '$date', 'FORE ALTERNANCE', '$formation', 'Baie-Mahault, Guadeloupe', '$Status',0, 1)";
    $co->query($sql);
    // Récupération du dernier IDoffers insérée dans la base de donnée
    $IDnewoffers = $co->insert_id;


    //Boucle avec concaténations de variables pour éviter de retaper a chaque fois et de faire pour tout les cas, c'est a dire du nombres
    for($i=2;$i<=$nbNiche;$i++){
        $formation = $_POST["formation".$i];
        $date = $_POST["date".$i];
        $hour = $_POST["hour".$i];
        $minutes = $_POST["minutes".$i];
        $duration = $_POST["duration".$i];

        $sql2 ="INSERT INTO offerssecond (IDoffers, Formation, date, Hour, Minutes, Duration, Status, IDtrainers) 
        VALUES ('$IDnewoffers','$formation', '$date', '$hour', '$minutes', '$duration', '$Status', '0')";
         $co->query($sql2);  
    }



}

   /*Dans un premier lieu je récupere les Identifians de chaque formateur qui enseigne la matière associé a l'offres déposé et ensuite grace a sa je remonte vers la table
   trainers pour récupere le numero de téléphone et si le trainers a été validée ont lui envoyé un message pour lui dire qu'une offres a été déposée.
   */

    $sql2SMS = "SELECT * FROM trainers WHERE IDtrainers in ( SELECT IDtrainers FROM subject where Subject = '$Subject') AND Validation = 1";
    $p2SMS = $co->query($sql2SMS);
    $nbRows = mysqli_num_rows($p2SMS);
    if($nbRows == 0 ){}
    else{
    while ($row2SMS = $p2SMS->fetch_assoc()) {

        // Synthaxe imposée par SUNSMS pour un envoie de message
        $Phone = $row2SMS['Phone'];
     
        $IDtrainers = $row2SMS['IDtrainers'];
    $connection = fopen('https://portal.sunsms.fr/api/1.0/simple/transactional', 'r', false,
    stream_context_create(['http' => [
    'method' => 'POST',
    'header' => [
        'Content-type: application/json'
    ],
    'content' => json_encode([
        'application_id' => '20630',
        'application_token' => 'lZSkQqBi1UmSmKjeLc4mtF4oyWGhJ2ODjJTZg6JJ9YxFZGN33T',
        'number' => $Phone,
        'text' => 'Une nouvelle missions pour une formation de '.$Subject.' a été déposée sur http://chronocoach.fr/vues/offers.php?ID='.$IDtrainers.' Vas vite la saisir, Chronocoach, une solution innovante MJ Metrix',
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

}

    


header("Location: ../vues/admin.php?ID=$ID");






?>