<?php

require_once('../bd/connect.php');
session_start();
//Recuperation de l'id de la missions pour laquel il faut compléter la fiche de presence mais aussi récupération de l'id de session de l'utilisateurs
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
<title>fiche de présence</title>
<link rel="stylesheet" href="../css/fichePresence.css">
<meta charset="UTF-8">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Suez+One&display=swap" rel="stylesheet">
<html>
<div class="topnav">
  <a class="active" href="membre.php">Retour</a>
</div>


  <div class="form">
    <h1 class="title">Fiche de présence</h1>
   
    <input type="hidden"  name="ID" value="<?php echo $ID; ?>" />
    <div class="container2">
    <label>Nom formateur : </label>
      <input type="text" id="nameTrainers" class="input" value="<?php echo $FirstName." ".$Surname; ?>" disabled />
    </div>

    <div class="container2">
    <label>Date : </label>
      <input type="text" id="date" class="input" value="<?php echo $date; ?>" disabled />
    </div>


    <div class="container2">
      <label>Formation : </label>
      <input type="text" id="formation"  class="input" value="<?php echo $formation; ?> " disabled />
      </div>


      <div class="container2">
      <label>Module : </label>
      <input type="text" id="module"  class="input" value="<?php echo $Subject; ?> " readonly/>
      </div>

      <div>


<table id='data' class='detailsOffers'>
  <tr> 
  <th rowspan="2">Nom-Prenom du stagière</th>
  <th colspan="2">EMARGEMENT</th>
    
   
  </tr>
  <tr>
    <th>Matin</th>
    <th>Apres-midi</th>
  </tr>

<?php

$sql5 = "SELECT * FROM student WHERE formation = '$formation'";
$p5 = $co->query($sql5);
$nbStudent = mysqli_num_rows($p5);
$i=1;
while ($row5 = $p5->fetch_assoc()) {
    $firstnameStudent = $row5['firstname'];
    $surnameStudent = $row5['surname'];
    echo "
    
    <tr>
    <td id='name$i'>$firstnameStudent  $surnameStudent</td>
    <td ><input id='matin$i' type='checkbox'  name='matin$i'></td>
    <td ><input id='apresmidi$i' type='checkbox' name='apresmidi$i'></td>
  </tr>
    ";
    $i++;

}


?>
  
</table>


      <div>
 
    <button class="btn" onclick="valider()">Valider</button>  
    <div id="message"></div>
  </div>
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


    var form = document.createElement("form")
    form.setAttribute('method', "POST")
    form.setAttribute('action', '../modeles/fichePresence.php')

    var nameTrainers = document.createElement('input')
    nameTrainers.setAttribute('type', 'hidden')
    nameTrainers.setAttribute('name', 'name')
    nameTrainers.setAttribute('value', document.getElementById('nameTrainers').value)
    form.appendChild(nameTrainers)

    var seconde = (<?= json_encode( $_POST['Seconde']); ?>);

    var Seconde = document.createElement('input')
    Seconde.setAttribute('type', 'hidden')
    Seconde.setAttribute('name', 'seconde')
    Seconde.setAttribute('value', seconde)
    form.appendChild(Seconde)


    var id = (<?= json_encode( $ID); ?>);

    var idOffers = document.createElement('input')
    idOffers.setAttribute('type', 'hidden')
    idOffers.setAttribute('name', 'id')
    idOffers.setAttribute('value', id)
    form.appendChild(idOffers)


    var date = document.createElement('input')
    date.setAttribute('type', 'hidden')
    date.setAttribute('name', 'date')
    date.setAttribute('value', document.getElementById('date').value)
    form.appendChild(date)

    var formation = document.createElement('input')
    formation.setAttribute('type', 'hidden')
    formation.setAttribute('name', 'formation')
    formation.setAttribute('value', document.getElementById('formation').value)
    form.appendChild(formation)

    
    var Module = document.createElement('input')
    Module.setAttribute('type', 'hidden')
    Module.setAttribute('name', 'module')
    Module.setAttribute('value', document.getElementById('module').value)
    form.appendChild(Module)

 var nbStudent = (<?= json_encode($nbStudent); ?>);



    var nbstudent = document.createElement('input')
    nbstudent.setAttribute('type', 'hidden')
    nbstudent.setAttribute('name', 'nbStudent')
    nbstudent.setAttribute('value', nbStudent)
    form.appendChild(nbstudent)



   
    for (let i = 1; i <= nbStudent; i++) {
        
        var name = document.createElement('input')
        name.setAttribute('type', 'hidden')
        name.setAttribute('name', 'name'+i)
        name.setAttribute('value', document.getElementById('name'+i).innerHTML)
        form.appendChild(name)

        var matin = document.createElement('input')
        matin.setAttribute('type', 'hidden')
        matin.setAttribute('name', 'matin'+i)
     
        matin.setAttribute('value', document.getElementById('matin'+i).checked)
        form.appendChild(matin)


        var apresmidi = document.createElement('input')
        apresmidi.setAttribute('type', 'hidden')
        apresmidi.setAttribute('name', 'apresmidi'+i)
        apresmidi.setAttribute('value', document.getElementById('apresmidi'+i).checked)
        form.appendChild(apresmidi)



        }

      document.getElementById('message').innerHTML="votre fiche de présence a été crée"
    document.body.appendChild(form);
    form.submit();
           



}



</script>
