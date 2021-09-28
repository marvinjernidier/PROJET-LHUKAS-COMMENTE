<html>

<title>Espaces membres</title>

</html>
<?php


//recupération de la session de l'utilisateur


require_once('../bd/connect.php');
session_start();

if ($_SESSION["IDtrainers"] != 0) {

  $IDtrainers = $_SESSION["IDtrainers"];
} else {
  header("Location: ../index.php");
  exit;
}


// recuperation des données du formateurs connecté
$sql = "SELECT * FROM trainers WHERE IDtrainers='$IDtrainers'";
$p1 = $co->query($sql);
while ($row = $p1->fetch_assoc()) {
  $FirstName = $row['FirstName'];
  $Surname = $row['Surname'];
  $Mail = $row['Mail'];
  $Phone = $row['Phone'];
  $City = $row['City'];
  $Validation = $row['Validation'];
  $Password = $row['Password'];
  $sponsorshipCode = $row["sponsorshipCode"];
  $point = $row["point"];
}
?>


<!DOCTYPE html>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Suez+One&display=swap" rel="stylesheet">
<html>

<head>
  <meta charset="utf-8">

  <link rel="stylesheet" href="../css/membre.css">

</head>

<body>
<div class="topnav">
<a href="acceuil_connecte.html"> <img class="logo"  src="../photo/logo1.png" ></a>

   

    <a href="../vues/acceuil_connecte.html#organisme" class="direction">Organisateur de formations</a>
    <a  href="../vues/acceuil_connecte.html#formateurs" class="direction">FORMATEURS</a>


    <a href="offers.php" class="direction">Offres</a>
  

   <a id="membre" class="aWhite" href="membre.php" >ESPACE MEMBRES</a>
    <a  id="deco" href="../modeles/logOut.php" class="aOrange" >DECONNEXION</a>
  </div>

  
  <div class="topnav2">
  <a href="acceuil_connecte.html"> <img class="logo"  src="../photo/logo1.png" ></a>
    <div class="dropdown">
      <img class="menu"  src="../photo/menu.png">

      <div class="dropdown-content">
      <a href="../vues/acceuil_connecte.html#organisme" class="direction">Organisateur de formations</a>
        <a  href="../vues/acceuil_connecte.html#formateurs" class="direction">FORMATEURS</a>
    
    
    
        <a href="offers.php" class="direction">Offres</a>
      
    
       <a id="membre" class="direction" href="membre.php" >ESPACE MEMBRES</a>
        <a  id="deco" href="../modeles/logOut.php" class="" >DECONNEXION</a>
      </div>
    </div>
  </div>


  <h1 class="title">ESPACE MEMBRE</h1>
  <div class="container" id="containerValidation">
  <p>Bonjour <strong><?php echo $Surname . "   " . $FirstName; ?></strong></p>



    <?php

    if ($Validation == 1) {
      echo "<a id='txtValidation'>Votre compte a été validé par l'équipe EDUC</a>
        <img src='../photo/valide.png' class='imgValidation'>";
    } else {

      echo "<a id='txtValidation'>Votre compte est en cours de validation par l'équipe EDUC</a>
        <img src='../photo/wait.png' class='imgValidation'>";
    }


    ?>
    
  </div>
  <div class="container">
    
<h2 class="title2">Code sponsors</h2>
    <p>Vous avez <strong><?php echo $point; ?></strong> point formateurs, et ci-dessous vous pouvez voir votre code de sponsor: </p>
    <input type="text" value="<?php echo $sponsorshipCode; ?>" disabled />
    <p>A chaque utilisation de votre code vous gagnerez 10 points formateurs mais aussi a chaque fois que vous éffecturez une mission, ces points vous permettront de passer devant les autres lors d'une offre.</p>

  </div>
  <div class="container">
<h2 class="title2">Informations complémentaires</h2>
    <form action="../modeles/change.php" method="post">
      <input type="text" placeholder="Mail" id="Mail" name="Mail" value="<?php echo $Mail; ?>" readonly />
      <input id="Phone" name="Phone" value="<?php echo $Phone; ?>" readonly />
      <input type="text" name="City" placeholder="City" id="City" value="<?php echo $City; ?>" readonly />
      
     <!-- <input type="text" placeholder="Old password" name="oldPassword" />
      <input type="text" name="City" placeholder="New password" name="newPassword" />
      <button class="btn">Comfirm change</button>
-->
    </form>

  </div>

  <?php

  /* Dans cette conditions nous vérifions que le formateur a été validée par l'equipe educ ou pas car l'affichage n'est pas le meme pour un formateur de validé et 
  un formateur qui n'est pas validé


  Si il est validé on affiche toutes les fonctionnalité qu'il peux avoir

  c'est a dire ajouter un élève, voir le récapitulatif des cours qu'il as à donner....
  
  */

  if ($Validation == 1) {
echo 
 "   <div class='container'>
 <h2 class='title2'>Ajouter un élève</h2>
        <form action='../modeles/addStudent.php' method='post'>
            <input type='text' placeholder='Nom' name='Nom'/>
            <input type='text' name='Prenom' placeholder='Prénom' />
            <select name='formation' class='select'>
            <option value=''>Veuillez choisir une formation</option>

           ";
$sql2 = "SELECT * FROM formation";
$p2 = $co->query($sql2);
while ($row = $p2->fetch_assoc()) {
echo "<option value=".$row['nomFormation'].">".$row['nomFormation']."</option>";

}

echo "</select>";
echo "<input type='hidden' name='ID' value=''/> 
<button class='btnAdd btn' onclick='addStudent()'>Ajouter</button>
</form>
</div>";

    /* A partir de la nous allons affiché le conteneur avec toutes les offres prisent par le formateur et pour chaque offres nous allons verifié dans la base de donnée 
    si celle ci possède des fiche de présence remplie ou des fiche d'activité remplie 
    si oui un bouton qui aura comme foncttionnalité d'afficher cette fiche et si non un bouton permettant de remplir celle ci.

    les variables sont initialisée dynamiquement car elle ce répete énormement et c'est plus optimisé de faire comme cela de manière dynamique




    l'opération ce répete plusieurs fois car il y a plusieurs cas ,

    un cas ou le formateur a accepté une offres principale, un deuxième cas ou le formateur a accepté une offre secondaire dans ce cas la il faut remonter avec l'identifiant
    de l'offre secondaire jusqu'a l'offre principale qui sont liée pour récuperer des informations importante et le derniers cas ou le formateur a accepté l'offre secondaire mais aussi l'offre principale



    */
    echo "
    <div class='container'>
    <h2 class='title2'>Récapitulatif des offres acceptées</h2>";

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
// Ceci est une sythaxe particuliere pour le graphique caneva
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


echo "<div id='chartContainer' style='height: 370px; width: 100%;'></div><p id='totalHour'></p>";

echo "<p class='separation'><p>";

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
        <h2> Module : $Subject </h2>
  
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
          $btnPresence = "<button class='btn' onclick=fichePresence($ID,$seconde) >Crée</button>";
        }


        if ($row3['ficheActivite'] == 1) {
          $linkFA = "../Fiche-activité-formateur/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
          $btnFA = "<button class='btn' onclick=openFILE('$linkFA') >Voir</button>";
        } else {
          $btnFA = "<button class='btn' onclick='ficheActivite($ID,$seconde)'>Crée</button>";
        }

        echo "
                <td>$date</td>
                 <td>$hour h $minutes</td>
                <td>$duration Hour</td>
                <td>$Formation</td>
                <td>$btnPresence</td>
                <td>$btnFA</td>
               ";


  
          echo  "</tr>";
        

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
            $btnPresence = "<button class='btn' onclick=fichePresence($ID,$seconde) >Crée</button>";
          }


          if ($row2['ficheActivite'] == 1) {
            $linkFA = "../Fiche-activité-formateur/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
            $btnFA = "<button class='btn' onclick=openFILE('$linkFA') >Voir</button>";
          } else {
            $btnFA = "<button class='btn' onclick='ficheActivite($ID,$seconde)'>Crée</button>";
          }

          echo "
                  <td>$date</td>
                   <td>$hour h $minutes</td>
                  <td>$duration Hour</td>
                  <td>$Formation</td>
                  <td>$btnPresence</td>
                  <td>$btnFA</td>
                 ";


                 echo  "</tr>";
        
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
        <h2> Module : $Subject</h2>
  
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
            $btnPresence = "<button class='btn' onclick=fichePresence($ID,$seconde) >Crée</button>";
          }


          if ($row2['ficheActivite'] == 1) {
            $linkFA = "../Fiche-activité-formateur/" . $FirstName . '-' . $Surname . '-' . $Formation . '-' . $Subject . '-' . $date . '.pdf';
            $btnFA = "<button class='btn' onclick=openFILE('$linkFA') >Voir</button>";
          } else {
            $btnFA = "<button class='btn' onclick='ficheActivite($ID,$seconde)'>Crée</button>";
          }

          echo "
                  <td>$date</td>
                   <td>$hour h $minutes</td>
                  <td>$duration Hour</td>
                  <td>$Formation</td>
                  <td>$btnPresence</td>
                  <td>$btnFA</td>
                 ";


                 echo  "</tr>";
echo " </table>";
  echo "<p class='separation'><p>";
  }
  
  
}



  }


 
  




    

              
  echo "</div>";
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

</html>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>

  /*

Ce block de code sers a initialiser le graphique caneva

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
<script>
    function addStudent(){
        alert("élève ajoutez")

    }

  /*
cette fonction crée un formulaire dynamiquement avec l'id de l'offre pour laquel il faut crée une fiche de présence 
et prend aussi en parametre si cette offres est une offre principale ou secondaire. 
ensuite elle éxecute ce formulaire qui renvoie vers une page pour compléter la fiche

  */

  function fichePresence(ID, seconde) {


    var form = document.createElement("form")
    form.setAttribute('method', "POST")
    form.setAttribute('action', 'fichePresenceFORM.php')

    var id = document.createElement('input')
    id.setAttribute('type', 'hidden')
    id.setAttribute('name', 'ID')
    id.setAttribute('value', ID)
    form.appendChild(id)


    var Seconde = document.createElement('input')
    Seconde.setAttribute('type', 'hidden')
    Seconde.setAttribute('name', 'Seconde')
    Seconde.setAttribute('value', seconde)
    form.appendChild(Seconde)



    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);


  }

 /*
cette fonction crée un formulaire dynamiquement avec l'id de l'offre pour laquel il faut crée une fiche de présence 
et prend aussi en parametre si cette offres est une offre principale ou secondaire. 
ensuite elle éxecute ce formulaire qui renvoie vers une page pour compléter la fiche

  */

  function ficheActivite(ID, seconde) {


    var form = document.createElement("form")
    form.setAttribute('method', "POST")
    form.setAttribute('action', 'ficheActiviteFORM.php')

    var id = document.createElement('input')
    id.setAttribute('type', 'hidden')
    id.setAttribute('name', 'ID')
    id.setAttribute('value', ID)
    form.appendChild(id)


    var Seconde = document.createElement('input')
    Seconde.setAttribute('type', 'hidden')
    Seconde.setAttribute('name', 'Seconde')
    Seconde.setAttribute('value', seconde)
    form.appendChild(Seconde)



    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);


  }


  function achieve(ID) {}

  function openFILE(URL) {
    window.open(URL)
    console.log(URL)
  }
</script>