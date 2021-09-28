<html>



<meta charset="UTF-8">
<title>Offres</title>

</html>

<?php

/*
Récuperation de l'id du formateur connecté par session ou avec l'url si rien n'est renseigné il est renvoyé a la page d'acceuil

*/
require_once('../bd/connect.php');

session_start();

if (isset($_SESSION["IDtrainers"])) {
  $IDtrainers = $_SESSION["IDtrainers"];
} else if ($_GET['ID'] != 0) {
  $IDtrainers = $_GET['ID'];
  $_SESSION["IDtrainers"] = $IDtrainers;
} else {
  header("Location: ../index.php");
  exit;
}

/*
On vérifie dans la base de donnée si le formateurs est validé ou non, si il n'est pas validé il n'as pas acces au offres de missions


*/
$sql = "SELECT * FROM trainers WHERE IDtrainers='$IDtrainers'";
$p1 = $co->query($sql);
while ($row = $p1->fetch_assoc()) {
  $Validation = $row['Validation'];
}
?>
<link rel="stylesheet" href="../css/offers.css">
<meta charset="UTF-8">


<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Suez+One&display=swap" rel="stylesheet">
<html>
<div class="topnav">
  <a href="acceuil_connecte.html"> <img class="logo" src="../photo/logo1.png"></a>



  <a href="../vues/acceuil_connecte.html#organisme" class="direction">Organisateur de formations</a>
  <a href="../vues/acceuil_connecte.html#formateurs" class="direction">FORMATEURS</a>

  <a href="offers.php" class="direction">Offres</a>


  <a id="membre" class="aWhite" href="membre.php">ESPACE MEMBRES</a>
  <a id="deco" href="../modeles/logOut.php" class="aOrange">DECONNEXION</a>
</div>

<div class="topnav2">
  <a href="acceuil_connecte.html"> <img class="logo" src="../photo/logo1.png"></a>
  <div class="dropdown">
    <img class="menu" src="../photo/menu.png">

    <div class="dropdown-content">
      <a href="../vues/acceuil_connecte.html#organisme" class="direction">Organisateur de formations</a>
      <a href="../vues/acceuil_connecte.html#formateurs" class="direction">FORMATEURS</a>


      <a href="offers.php" class="direction">Offres</a>


      <a id="membre" class="direction" href="membre.php">ESPACE MEMBRES</a>
      <a id="deco" href="../modeles/logOut.php" class="">DECONNEXION</a>
    </div>
  </div>
</div>


<?php
if ($Validation == 1) {

  $nbTotalOffers = 0;


  $nbOffers = 0;

  /*

les offres qui sont affiché sont uniquement  celle que le formateur a dis qu'il enseigne lors de son inscpription,
si il a renseigné qu'il enseigne uniquement du marketing il aura uniquement des missions de marketing affiché et pas d'autres.


  */

  $sql2 = "SELECT * FROM offers WHERE subject in ( SELECT subject FROM subject where IDtrainers = $IDtrainers)  ";
  $p2 = $co->query($sql2);
  $nbRows = mysqli_num_rows($p2);


  if ($nbRows == 0) {
    echo "<div class='container' id='noOffers' >
    <h1>Pas de missions a saisir pour le moment.</h1>
    </div>";
  } else {
    echo "<h1 class='title'>Offres disponibles</h1>";
    echo "<div class='test'>";
    echo "<div class='left'>
   <div class='texte'>
   <img  class='icon' src='../photo/1.png' >
   <div>
   <span>Choisis une ou plusieurs mission(s) </span>
   <p>Sélectionnes la ou les missions qui t'intéressent, fais défiler les offres à l'aide des flèches et quant tu as sélectionner toutes 
   qui te corresponde clique sur le bouton 'accepter mission(s)' </p>
   </div>
   </div>
   <div class='texte'>
   <img  class='icon' src='../photo/2.png' >
   <div>
   <span>Remplis ta mission !</span>
   <p>Accomplis ta missions et n'oublie pas de remplir la fiche de présence et la fiche d'activité de la mission que tu as éffectuée.</p>
   </div>
   </div>
   <div class='texte'>
   <img  class='icon' src='../photo/3.png' >
   <div>
   <span>Perçois ton paiement </span>
   <p>L'organisme de formation relatif à la mission accomplie se chargera de te faire parvenir ta rémunération.</p>
   </div>
   </div>
   </div>";




    echo "<div class='slideshow-container'>
    <div class='entete'>
    <a id='dispoMissions'>MISSIONS DISPONIBLES</a>
    <a id='offresNumber'></a> </div>";

    echo "<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>
    <a class='next' onclick='plusSlides(1)'>&#10095;</a>";



/*
Dans le block de code suivant nous allons affiché toutes les missions qui n'ont pas encore été prise, c'est a dire les mission disponible

*/
    $num = 1;
    echo "<div class='mySlides fade'>";
    echo "<div class='container' style='width: 50%;'>
        <h1>Utilisez la flèches droite et gauche pour faire défiler les offres, si rien
         ne s'affiche cela signifie qu'aucune offres n'est
         disponibles pour le moment. </h1>
        </div>
        </div>";
    while ($row2 = $p2->fetch_assoc()) {
      $ID = $row2['IDoffers'];
      $nameSchool = $row2['NameSchool'];
      $City = $row2['City'];
      $Formation = $row2['nameFormation'];
      $Subject = $row2['Subject'];
      $date = $row2['date'];
      $hour = $row2['Hour'];
      $minutes = $row2['Minutes'];
      $Status = $row2['Status'];
      $duration = $row2['Duration'];
      $offersSeconde = $row2['offersSecond'];



      $sql3 = "SELECT * FROM offerssecond WHERE IDoffers='$ID' AND Status = 'Untreated' ";
      $p3 = $co->query($sql3);
      $nbRowsOS = mysqli_num_rows($p3);



      if ($Status == "Untreated" || $nbRowsOS != 0) {
        echo "<div class='mySlides fade'>";
        echo "<div class='container' '>
        <h1>MODULE : " . strtoupper($Subject) . " </h1> 
        <table class='detailsOffers'>
              <tr>
                <th>Name of School</th>
                <th>City</th> 
              </tr>
            <tr>
            <td>$nameSchool</td>
            <td>$City</td>
            </tr>
            </table>";
        $nbOffers++;
        echo "<h3>Details de la mission ou les missions</h3>
           ";
      }






      if ($Status == "Untreated") {


        echo " 
  
            <table class='detailsOffers' onclick='acceptMission(this,0,$ID,$num)'>
              
            <tr>
            <th> Date </th>
            <th> Hour </th>
             <th> Duration </th>
               <th> Formation </th>
            </tr>
            <tr>
            <td>  $date </td>
            <td>  $hour h $minutes </td>
         <td>  $duration H </td>
        <td>  $Formation </td>
            </tr>
            
           </table>
           <input type='hidden' value='$Subject' id='subject$num'>
        
         ";
        $num++;
      }

      if ($offersSeconde == 1) {

        while ($row3 = $p3->fetch_assoc()) {
          $FormationSeconde = $row3['Formation'];
          $IDofferSeconde = $row3['IDofferSeconde'];
          $DateSeconde = $row3['date'];
          $HourSeconde = $row3['Hour'];
          $MinuteSeconde = $row3['Minutes'];
          $DurationSeconde = $row3['Duration'];
          $StatusSeconde = $row3['Status'];
          $Seconde = true;

          if ($StatusSeconde == 'Untreated') {

            echo "
      <table class='detailsOffers' onclick='acceptMission(this,$Seconde,$IDofferSeconde,$num)'>

      <tr>
      <th> Date </th>
      <th> Hour </th>
      <th> Duration </th>
      <th> Formation </th>
      </tr>

      <tr> 
       <td>  $DateSeconde</td>
      <td>  $HourSeconde H $MinuteSeconde </td>
      <td>  $DurationSeconde H </td>
      <td>  $FormationSeconde </td>
      </tr>


     
     </table>
     <input type='hidden' value='$Subject' id='subject$num'>
     ";
            $num++;
          }
        }
      }


      if (isset($Seconde)) {
        $nbTotalOffers++;
        if ($Status == "Untreated" || $Seconde == true) {

          echo " </div>";
          echo "<button class='aWhite' onclick='validation()' id='btnValidation' >Accepter missions</button> ";
          echo "</div>";
        }
      } else {
        $nbTotalOffers++;
        if ($Status == "Untreated") {
          echo " </div>";
          echo "<button class='aWhite' onclick='validation()' id='btnValidation' >Accepter missions</button> ";
          echo "</div>";
        }
      }
    }
  }



  echo "</div>";
  echo "</div>";
  if($nbRows == 0){
 echo "<div class='footer' style='position: absolute;'>";
  }else{
    echo "<div class='footer'>";
  }
  
} else {
  echo "   <div class='container containerNOVALIDATE'>

<h1>Votre compte n'a pas encore été validé par notre équipe, vous n'avez donc pas accès à cette page d'offres.</h1>



</div>";
  echo "<div class='footer' style='position: absolute;'>";
}


?>





<div class="entreprise">
  <img class="logoFooter" src="../photo/logoMJmetrix.png">
  <p>Site réalisé par MJ METRIX</p>
  <p>Agence digitale en Guadeloupe & Martinique</p>
</div>


<div class="contact">

  <p>Rejoignez-nous sur les réseaux </p>
  <a onclick='window.open ("https://www.facebook.com/realmjmetrix")'><img class="logoSocial" src="../photo/facebook.png"></a>
  <a onclick='window.open ("https://www.google.com/maps/place/MJ+Metrix+-+Agence+digitale+en+Guadeloupe/@16.241951,-61.5702357,17z/data=!3m1!4b1!4m5!3m4!1s0x8c13453310392ccf:0xd1bf5097a38d7599!8m2!3d16.241951!4d-61.568047")'><img class="logoSocial" src="../photo/google.png"></a>
</div>




</div>

</html>





<script>
  /*
Les missions sont placé dans un encadré qui fonctionne comme un diaporama/ un slider de ce faite nous avons des bouton a droite et a gauche qui permette de faire défiler les missions ( slides )

ceci ce fait grace au fonction ci dessous

  */
  var slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) {

    showSlides(slideIndex += n);

  }

  function currentSlide(n) {
    showSlides(slideIndex = n);

  }

  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    total = slides.length - 1;
    if (n > slides.length) {
      slideIndex = 1
    }
    if (n < 1) {
      slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    document.getElementById('offresNumber').innerHTML = "OFFRES " + (slideIndex - 1) + "/" + total;

    slides[slideIndex - 1].style.display = "block";
  }
</script>


<script type="text/javascript">
/*
Dans cette partie de code j'ajoute une image dynamiquement a chaque fois que le formateur choisi une missions, la photo est une encoche de validation pour imformer le formateur que sa selection as bien 
été prise en compte

*/
  var img = document.createElement("img");
  img.classList.add('validate')
  img.setAttribute('name', 'image')
  img.setAttribute('name', 'image')
  img.src = "../photo/coche.png";



  imgClone = img.cloneNode(true)
  var nbOffersTaken = 0

  var form = document.createElement("form")
  form.setAttribute('method', "POST")
  form.setAttribute('action', "../modeles/acceptOffre.php")

  acceptFirstOffers = false;
  nbOffer = 0;


  /*
cette fonction permet de comfirmer le choix de  toutes les missions choisi par le formateurs

si aucune missions n'as été prise un message s'affiche indiquant au formateur qu'il faut choisir au moins une missiosn

  */
  function validation() {
    if (nbOffersTaken == 0) {
      alert('Veuillez choisir au moins une missions')
    } else {
      var nbOffers = document.createElement('input')
      nbOffers.setAttribute('type', 'hidden')
      nbOffers.setAttribute('name', 'nbOffers')
      nbOffers.setAttribute('value', nbOffersTaken)
      form.appendChild(nbOffers)

      document.body.appendChild(form);
      form.submit();
      document.body.removeChild(form);

    }
  }



  /*
A chaque fois que le formateur choisi une missions cette missions est stocké dans un formulaire caché qui sera ensuite
envoyé a une autre page plors de la comfirmation du formateur sur son choix de missions 




  */
  function acceptMission(element, seconde, ID, num, subject) {
    nbOffer = num
    if (element.style.border == "3px solid red") {
      nbOffersTaken--;
      element.style.border = "";
      // ajouter l'offres seconde au formulaire

      document.getElementsByName('seconde' + num)[0].remove()
      document.getElementsByName('Offers' + num)[0].remove()
      document.getElementsByName('Subject' + num)[0].remove()
      element.removeChild(element.lastElementChild)
    } else {

      element.appendChild(img.cloneNode(true))

      nbOffersTaken++;
      element.style.border = "3px solid red";

      this["seconde" + num] = document.createElement('input')
      this["seconde" + num].setAttribute('type', 'hidden')
      this["seconde" + num].setAttribute('name', 'seconde' + num)
      this["seconde" + num].setAttribute('value', seconde)
      form.appendChild(this["seconde" + num])

      this["Offers" + num] = document.createElement('input')
      this["Offers" + num].setAttribute('type', 'hidden')
      this["Offers" + num].setAttribute('name', 'Offers' + num)
      this["Offers" + num].setAttribute('value', ID)
      form.appendChild(this["Offers" + num])

      this["Subject" + num] = document.createElement('input')
      this["Subject" + num].setAttribute('type', 'hidden')
      this["Subject" + num].setAttribute('name', 'Subject' + num)
      this["Subject" + num].setAttribute('value', document.getElementById("subject" + num).value)
      form.appendChild(this["Subject" + num])
      console.log(form)
      console.log('///////////')

    }
    document.body.appendChild(form);

   
  }
</script>