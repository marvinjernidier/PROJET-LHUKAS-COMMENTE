<?php
require_once('../bd/connect.php');


//Requète pour valider un trainers

$IDEduc = $_GET["ID"];
$ID = $_POST["IDTrainers"];
$sql = "UPDATE trainers SET Validation = 1 WHERE IDtrainers = $ID";
$p1 = $co->query($sql);




//Block de code servant a envoyé un message a ce trainers pour lui dire que son compté a été validée.
$sql2SMS = "SELECT * FROM trainers WHERE IDtrainers='$ID' ";
$p2SMS = $co->query($sql2SMS);
while ($row2SMS = $p2SMS->fetch_assoc()) {
$Phone = $row2SMS['Phone'];
}
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
    'text' => 'Votre compte a été validé par la team EDUC vous pouvez maintenant voir les offres disponibles sur https://chronocoach.fr/vues/offers.php?ID='.$ID.' Vas vite la saisir, Chronocoach, une solution innovante MJ Metrix',
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


header("Location: ../vues/admin.php?ID=$IDEduc");
?>


