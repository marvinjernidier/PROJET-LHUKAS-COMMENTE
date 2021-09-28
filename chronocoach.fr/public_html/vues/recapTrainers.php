<!DOCTYPE html>
<title>Recapitulatif</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/recapTrainer.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Suez+One&display=swap" rel="stylesheet">
<html>

<?php
require_once('../bd/connect.php');

// récuperation du nom et prenom du formateur passé par l'url
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];


$ID = $_POST['ID'];

echo "<div class='topnav'>
<a class='active' href='admin.php?ID=$ID'>Retour</a>
</div>";

$trouve = false;

/*

recherche du formateur dans la base de donnée grace au nom et au prénom passé dans l'url

*/
$sql = "SELECT * FROM trainers";
$p1 = $co->query($sql);
while ($row = $p1->fetch_assoc()) {


//Si on trouve une correspondance on récupere toutes les informations de celui ci
  if (strtoupper($nom) == strtoupper($row['Surname']) && strtoupper($prenom) == strtoupper($row['FirstName'])) {
    $IDtrainers = $row['IDtrainers'];
    $FirstName = $row['FirstName'];

    $Surname = $row['Surname'];
    $Mail = $row['Mail'];
    $Phone = $row['Phone'];
    $City = $row['City'];
    $Validation = $row['Validation'];
    $Password = $row['Password'];
    $sponsorshipCode = $row["sponsorshipCode"];
    $point = $row["point"];

    $trouve = true;
  }
}



echo "<div class='container'>";



if ($trouve == true) {
  $nom = $FirstName;

  $prenom = $Surname;

  echo "
<h1>Information liée a ce formateur</h1>
<table class='detailsOffers'>
<tr> 
<th>Nom complet</th>
</tr>
<tr> 
<td>$nom  $prenom</td>
</tr>
<tr> 
<th>Mail</th>
</tr>
<tr> 
<td>$Mail</td>
</tr>
<tr> 
<th>Téléphone</th>
</tr>
<tr> 
<td>$Phone</td>
</tr>
<tr> 
<th>Ville</th>
</tr>
<tr> 
<td>$City</td>
</tr>
<tr> 
<th>Point</th>
</tr>
<tr> 
<td>$point</td>
</tr>
</table>";

  echo "<h1>Missions réalisé par ce formateur</h1>";


  //////////////////////////////
/* A partir de la nous allons chercher dans la base de donnée toutes les offres prisent par le formateur et pour chaque offres nous allons verifié dans la base de donnée 
    si celle ci possède des fiche de présence remplie ou des fiche d'activité remplie 
    si oui un bouton qui aura comme foncttionnalité d'afficher cette fiche et si non un messge indiqiant qu'elle n'as pas encore été remplie.

    les variables sont initialisée dynamiquement car elle ce répete énormement et c'est plus optimisé de faire comme cela de manière dynamique




    l'opération ce répete plusieurs fois car il y a plusieurs cas ,

    un cas ou le formateur a accepté une offres principale, un deuxième cas ou le formateur a accepté une offre secondaire dans ce cas la il faut remonter avec l'identifiant
    de l'offre secondaire jusqu'a l'offre principale qui sont liée pour récuperer des informations importante et le derniers cas ou le formateur a accepté l'offre secondaire mais aussi l'offre principale


    tous cela est fait remplir le graphique canva avec ces information


    */

  $i =0;
    $sql3 = "SELECT * FROM subject WHERE IDtrainers =  $IDtrainers";
    $p3 = $co->query($sql3);
    
    while ($row3 = $p3->fetch_assoc()) {
      $i++;
     ${'SubjectTrainers'.$i}=$row3['Subject'];
     ${'SubjectTrainersDuration'.$i}=0;
    
     $Subject = $row3['Subject'];
    
     
          $sql4 = "SELECT * FROM offers WHERE IDtrainers = $IDtrainers AND Subject = '$Subject'";
          $p4 = $co->query($sql4);
          while ($row4 = $p4->fetch_assoc()) {
            ${'SubjectTrainersDuration'.$i}+=$row4['Duration'];
            $ID = $row4['IDoffers'];
           
    
    
            $sql2 = "SELECT * FROM offerssecond WHERE IDoffers = $ID  AND IDtrainers =  $IDtrainers";
            $p2 = $co->query($sql2);
            while ($row2 = $p2->fetch_assoc()) {
              ${'SubjectTrainersDuration'.$i}+=$row2['Duration'];
              
          }
    
         
            
          }
           $sql5 = "SELECT * FROM offerssecond WHERE IDtrainers =  $IDtrainers AND IDoffers in (SELECT IDoffers FROM offers WHERE Status = 'Untreated' AND Subject = '$Subject') ";
            $p5 = $co->query($sql5);
            while ($row5 = $p5->fetch_assoc()) {
              ${'SubjectTrainersDuration'.$i}+=$row5['Duration'];
              
    
          }
      }

   
      $dataPoints = array();
      $totalHour=0;
    if(isset($SubjectTrainers1)){
      $totalHour+=$SubjectTrainersDuration1;
      array_push( $dataPoints,array("label"=> "$SubjectTrainers1","y"=> $SubjectTrainersDuration1) );
  }
  
  if(isset($SubjectTrainers2)){
    $totalHour+=$SubjectTrainersDuration2;
    array_push( $dataPoints,array("label"=> "$SubjectTrainers2","y"=> $SubjectTrainersDuration2) );
  }
  if(isset($SubjectTrainers3)){
  
    $totalHour+=$SubjectTrainersDuration3;
    array_push( $dataPoints,array("label"=> "$SubjectTrainers3","y"=> $SubjectTrainersDuration3) );
  }


echo "<div id='chartContainer' style='height: 370px; width: 80%; margin:auto'></div><p id='totalHour'></p>";

echo "<p class='separation'><p>";
  ///////////////
  

  $sql3 = "SELECT * FROM offers WHERE IDtrainers =  $IDtrainers";
  $p3 = $co->query($sql3);
  $nbRows = mysqli_num_rows($p3);

  while ($row3 = $p3->fetch_assoc()) {
    $IDoffer = $row3['IDoffers'];
    $nameSchool = $row3['NameSchool'];
    $City = $row3['City'];
    $Subject = $row3['Subject'];

    echo "    
      <table class='detailsOffers'>
        <tr>
          <th>Name of School</th>
          <th>City</th>  
        </tr>
      <tr>
      <td>$nameSchool</td>
      <td>$City</td>
      </tr>
      </table>
      <h2> $Subject lesson</h2>

      <table class='detailsOffers'> 
      <tr class='first'>
          <th>Date</th>  
          <th>Hour</th>
          <th>duration</th>  
          <th>Formation</th> 
          <th>Fiche PRESENCE</th>  
          <th>FICHE ACTIVITÉ FORMATEUR </th>  
            
        </tr>
      <tr>";

      $ID = $row3['IDoffers'];
      $Formation = $row3['nameFormation'];
      $date = $row3['date'];
      $hour = $row3['Hour'];
      $minutes = $row3['Minutes'];
      $duration = $row3['Duration'];
      $seconde=0;
     


      if ($row3['fichePresence'] == 1) {
        $linkFP = "../Fiche-Présence/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
        $btnPresence = "<button class='btn' onclick=openFILE('$linkFP') >Voir</button>";
      } else {
        $btnPresence = "<p>La fiche n'as pas encore été renseigné</p>";
      }


      if ($row3['ficheActivite'] == 1) {
        $linkFA = "../Fiche-activité-formateur/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
        $btnFA = "<button class='btn' onclick=openFILE('$linkFA') >Voir</button>";
      } else {
        $btnFA = "<p>La fiche n'as pas encore été renseigné</p>";
      }

      echo "
              <td>$date</td>
               <td>$hour h $minutes</td>
              <td>$duration Hour</td>
              <td>$Formation</td>
              <td>$btnPresence</td>
              <td>$btnFA</td>
             ";


      
      echo "</tr>";
///////////////////////////
$sql2 = "SELECT * FROM offerssecond WHERE IDoffers =$IDoffer AND IDtrainers =  $IDtrainers ";
$p2 = $co->query($sql2);

while ($row2 = $p2->fetch_assoc()) {

    $ID = $row2['IDofferSeconde'];
    $Formation = $row2['Formation'];
    $date = $row2['date'];
    $hour = $row2['Hour'];
    $minutes = $row2['Minutes'];
    $duration = $row2['Duration'];
    $seconde = 1;


    if ($row2['fichePresence'] == 1) {
      $linkFP = "../Fiche-Présence/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
      $btnPresence = "<button class='btn' onclick=openFILE('$linkFP') >Voir</button>";
    } else {
      $btnPresence = "<p>La fiche n'as pas encore été renseigné</p>";
    }


    if ($row2['ficheActivite'] == 1) {
      $linkFA = "../Fiche-activité-formateur/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
      $btnFA = "<button class='btn' onclick=openFILE('$linkFA') >Voir</button>";
    } else {
      $btnFA = "<p>La fiche n'as pas encore été renseigné</p>";
    }

    echo "
            <td>$date</td>
             <td>$hour h $minutes</td>
            <td>$duration Hour</td>
            <td>$Formation</td>
            <td>$btnPresence</td>
            <td>$btnFA</td>
           ";


           echo "</tr>";
  
}
////////////////////////////////////////////////
echo " </table>";
echo "<p class='separation'><p>";
    }
    ////////////////////////////////////////////////////////////////////////////pour les offers seconde seule
    $sql3 = "SELECT * FROM offers WHERE Status = 'Untreated' ";
    $p3 = $co->query($sql3);
    while ($row3 = $p3->fetch_assoc()) {

      $nameSchool = $row3['NameSchool'];
      $City = $row3['City'];
      $Subject = $row3['Subject'];
      $one = false;
      $ID = $row3['IDoffers'];


      $sql2 = "SELECT * FROM offerssecond WHERE IDtrainers =  $IDtrainers AND IDoffers =$ID ";
      $p2 = $co->query($sql2);

      while ($row2 = $p2->fetch_assoc()) {

        if($one == false){
          $one = true;
          echo "    
        <table class='detailsOffers'>
          <tr>
            <th>Name of School</th>
            <th>City</th>  
          </tr>
        <tr>
        <td>$nameSchool</td>
        <td>$City</td>
        </tr>
        </table>
        <h2> $Subject lesson</h2>
  
        <table class='detailsOffers'> 
        <tr class='first'>
            <th>Date</th>  
            <th>Hour</th>
            <th>duration</th>  
            <th>Formation</th> 
            <th>Fiche PRESENCE</th>  
            <th>FICHE ACTIVITÉ FORMATEUR </th>  
               
          </tr>
        <tr>";

  
        }
        $ID = $row2['IDofferSeconde'];
          $Formation = $row2['Formation'];
          $date = $row2['date'];
          $hour = $row2['Hour'];
          $minutes = $row2['Minutes'];
          $duration = $row2['Duration'];
          $seconde = 1;


          if ($row2['fichePresence'] == 1) {
            $linkFP = "../Fiche-Présence/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
            $btnPresence = "<button class='btn' onclick=openFILE('$linkFP') >Voir</button>";
          } else {
            $btnPresence = "<p>La fiche n'as pas encore été renseigné</p>";
          }


          if ($row2['ficheActivite'] == 1) {
            $linkFA = "../Fiche-activité-formateur/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
            $btnFA = "<button class='btn' onclick=openFILE('$linkFA') >Voir</button>";
          } else {
            $btnFA = "<p>La fiche n'as pas encore été renseigné</p>";
          }

          echo "
                  <td>$date</td>
                   <td>$hour h $minutes</td>
                  <td>$duration Hour</td>
                  <td>$Formation</td>
                  <td>$btnPresence</td>
                  <td>$btnFA</td>
                 ";


                 echo "</tr>";
echo " </table>";
  echo "<p class='separation'><p>";
  }
  
}




echo "</div>";
echo "<div class='footer'>";

} else {

  echo "<h2>aucun formateur de ce nom trouvé";
  echo "</div>";
  echo "<div class='footer' style='position: absolute;'>";
}






?>
</body>
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



<script>
  function openFILE(URL) {
    window.open(URL)
 
  }
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>


/*
Synthaxe pour initialiser le graphique canva

*/
window.onload = function () {
  document.getElementById('totalHour').innerHTML = "Nombre total d'heures éffectuée : "+(<?= json_encode($totalHour); ?>);
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title: {
		text: ""
	},
	axisY: {
		title: "nombre heures"
	},
	data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>