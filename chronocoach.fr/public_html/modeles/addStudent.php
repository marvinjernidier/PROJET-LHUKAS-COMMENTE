<?php
require_once('../bd/connect.php');

//remplace les espace dans le nom et le prénom par des -
$nom = str_replace(' ', '-',strtoupper($_POST["Nom"]));
$prenom = str_replace(' ', '-',strtoupper($_POST["Prenom"]));
$formation = $_POST["formation"];

//requete pour inserer un étudiant dans la base de donnée
$req= "INSERT INTO student (IDstudent,firstname,surname,formation)
VALUES (null,'$nom','$prenom','$formation')";
$co->query($req);

// vérification si c'est un administrateur ou un formateur qui as ajouté l'étudiant.
if($_POST["ID"] == null){

    header("Location: ../vues/membre.php ");

}
else {
    $ID = $_POST["ID"]; 
    header("Location: ../vues/admin.php?ID=$ID ");    
}







?>