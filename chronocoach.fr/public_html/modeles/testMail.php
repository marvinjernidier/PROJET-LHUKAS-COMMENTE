<?php
require_once('../bd/connect.php');
$foundMail=0;
//Récupération des variables envoyé grace au formulaires.
$Mail = $_REQUEST["mail"];


$sql="SELECT * FROM trainers";
$p1 = $co->query($sql);
	while ($row = $p1->fetch_assoc() )  
	{
        if($row['Mail'] == $Mail) {
            $foundMail = 1;
        }
	}


echo $foundMail;


?>
