<?php
// Génère : <body text='black'>
$bodytag = str_replace("%body%", "black", "<body text='%body%'>");

// Génère : Hll Wrld f PHP
$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
$onlyconsonants = str_replace($vowels, "", "Hello World of PHP");

// Génère : You should eat pizza, beer, and ice cream every day
$phrase  = "You should eat fruits, vegetables, and fiber every day.";
$healthy = array("fruits", "vegetables", "fiber");
$yummy   = array("pizza", "beer", "ice cream");

$newphrase = str_replace($healthy, $yummy, $phrase);

// Génère : good goy miss moy
$str = str_replace("ll", "", "good golly miss molly!", $count);
echo $str;

?>