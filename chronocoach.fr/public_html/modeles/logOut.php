<?php 

//Deconnexion et supréssion de la sessions

session_start();
session_destroy();
header("Location: ../index.php");    



?>