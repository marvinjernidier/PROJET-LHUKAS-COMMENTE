<?php

require_once('../bd/connect.php');
session_start();
//Recuperation de l'id de la missions pour laquel il faut compléter la fiche d'activité mais aussi récupération de l'id de session de l'utilisateurs
$ID=$_POST['ID'];
$IDtrainers = $_SESSION["IDtrainers"];

//requete pour récuperer tous les informations du formateur qui remplie cette fiche
$sql = "SELECT * FROM trainers WHERE IDtrainers='$IDtrainers'";
$p1 = $co->query($sql);
while ($row = $p1->fetch_assoc()) {
    $FirstName = $row['FirstName'];
    $Surname = $row['Surname'];
    $Mail = $row['Mail'];
    $Phone = $row['Phone'];
    $sponsorshipCode = $row["sponsorshipCode"];
   


}
/*

Dans le bloc de code qui suit nous allons faire une vérification pour voir si l'offres que l'utilisateur vas completer est une offres ou une sous-offres
car en fonction de cela il y aura un traitement different


Pour informations chaque sous-offres est liée a une offres donc pour éviter une récurrence inutile au niveau des donnée certaines informations comme le lieu de la formation est répertorié dans l'offres
et pas la sous-offres car si il y a 10 sous offres, nous n'allons pas stockers 10 fois le meme lieu de ce fait l'adresse ou éffectuer la missions ce trouve dans l'offres et cest 10 sous offres sont relié a celle-ci.

*/
if ($_POST['Seconde'] == 1){
    $sql3 = "SELECT * FROM offerssecond WHERE IDofferSeconde ='$ID'";
    $p3 = $co->query($sql3);
    while ($row3 = $p3->fetch_assoc()) {
        $IDoffer = $row3['IDoffers'];
        $IDofferSecond = $row3['IDofferSeconde'];
        $formation = $row3['Formation'];
        $date = $row3['date'];
        $hour = $row3['Hour'];
        $minute = $row3['Minutes'];
        $duration = $row3['Duration'];
    }

    
    $sql4 = "SELECT * FROM offers WHERE IDoffers =  $IDoffer";
    $p4 = $co->query($sql4);
    while ($row4 = $p4->fetch_assoc()) {
        $Subject = $row4['Subject'];
        $NameSchool = $row4['NameSchool'];
        $NameSchool = $row4['City'];
    }
}
else if ($_POST['Seconde'] == 0)
{

    $sql4 = "SELECT * FROM offers WHERE IDoffers =  $ID";
    $p4 = $co->query($sql4);
    while ($row2 = $p4->fetch_assoc()) {
        $formation = $row2['nameFormation'];
        $date = $row2['date'];
        $hour = $row2['Hour'];
        $minutes = $row2['Minutes'];
        $duration = $row2['Duration'];
        $Subject = $row2['Subject'];
    }



}
?>


<!DOCTYPE html>
<title>fiche activité</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/fichePresence.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Suez+One&display=swap" rel="stylesheet">
<html>
<div class="topnav">
  <a class="active" href="membre.php">Retour</a>
</div>


  <div class="form">
 <h1 class="title">Fiche journalière activite formateur</h1>
  <form action="../modeles/ficheActivite.php" method="post"  >


   
  <input type="hidden"  name="seconde" value="<?php echo $_POST['Seconde']; ?>" />
   
  <input type="hidden"  name="ID" value="<?php echo $ID; ?>" />
  
  <label>Nom formateur : </label>
    <input type="text" name="name" id="nameTrainers" class="input" value="<?php echo $FirstName." ".$Surname; ?>" readonly />



  <label>Date : </label>
    <input type="text" id="date" name="date" class="input" value="<?php echo $date; ?>" readonly />



    <label>Formation : </label>
    <input type="text" id="formation"  name="formation" class="input" value="<?php echo $formation; ?> " readonly />




    <label>Module : </label>
    <input type="text" id="module" name="module" class="input" value="<?php echo $Subject; ?> " readonly/>

    <label>Objectif de la scéance : </label>
    <textarea rows = "7" class="input" name = "objectif">
         
       </textarea>

       
    <label>Contenue de la scéance: </label>
    <textarea rows = "7" class="input" name = "contenue">
          
       </textarea>


       <label>Support utilisée : </label>
    <textarea rows = "7" class="input" name = "support">
         
       </textarea>

       <label>remarques : </label>
    <textarea rows = "7" class="input" name = "remarque">
         
       </textarea>



<button class="btn" onclick="valider()">Valider</button>  
      </form>
   
      <div>





 
 
    
    <div id="message"></div>
  </div>
  </div>
  <div class="footer">
 

 <div class="entreprise">
   <img class="logoFooter"  src="../photo/logoMJmetrix.png">
   <p>Site réalisé par MJ METRIX</p>
   <p>Agence digitale en Guadeloupe & Martinique</p>
 </div>
 

 <div class="contact">
   
   <p>Rejoignez-nous sur les réseaux </p>
   <a onclick= 'window.open ("https://www.facebook.com/realmjmetrix")' ><img class="logoSocial"  src="../photo/facebook.png"></a>
   <a onclick= 'window.open ("https://www.google.com/maps/place/MJ+Metrix+-+Agence+digitale+en+Guadeloupe/@16.241951,-61.5702357,17z/data=!3m1!4b1!4m5!3m4!1s0x8c13453310392ccf:0xd1bf5097a38d7599!8m2!3d16.241951!4d-61.568047")' ><img class="logoSocial"  src="../photo/google.png"></a>
 </div>




</div>

</html>

<script>

function valider(){





      document.getElementById('message').innerHTML="votre fiche de présence a été crée"
    
           



}



</script>
