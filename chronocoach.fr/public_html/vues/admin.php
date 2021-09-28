<!DOCTYPE html>
<link rel="stylesheet" href="../css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Suez+One&display=swap" rel="stylesheet">
<html>
<div class="topnav">
    <a class="active" href="../modeles/logOut.php">Deconnexion</a>
    <img class="logo" src="../photo/logo.png">

</div>
<h1 class='title'>Pages pour responsable pédagogique</h1>


    <?php
    //récupération du nom et prenom de la personne connecté pour afficher un message de bienvenu
    require_once('../bd/connect.php');
    if($_GET['ID'] != 0){
        $IDeduc = $_GET['ID'];
        $sqlADMIN="SELECT * FROM educ WHERE IDeduc = '$IDeduc'";
        $pADMIN = $co->query($sqlADMIN);
	    while ($rowADMIN = $pADMIN->fetch_assoc() )  
	    {
            echo "<h3 class ='title'> Bienvenue ".$rowADMIN['Surname']." ".$rowADMIN['FirstName']."</h3> <div class='container'>";
        }


      } 
      else{
        header("Location: ../index.php");
        exit;
      }

    //Récuperation de tout les formateurs qui ne sont pas validé et pour les affichée avec un bouton validation qui permettera de valider les formateurs non-validé
    $nbTrainers = 0;
    $sql2 = "SELECT * FROM trainers WHERE Validation=0";
    $p2 = $co->query($sql2);
    $nbRows = mysqli_num_rows($p2);
    if ($nbRows == 0) {
        echo "<h1>Pas de formateur a valider</h1>";
    } else {

        echo "
<h1>Formateurs a valider : </h1>
<table class='detailsOffers'>
            <tr>
              <th>First Name</th>
              <th>Surname</th> 
            
              <th>Phone</th> 
              <th>City</th> 
              <th>CV</th> 
            </tr>
";

        while ($row = $p2->fetch_assoc()) {
            $ID = $row['IDtrainers'];
            $FirstName = $row['FirstName'];
            $Surname = $row['Surname'];
            $Mail = $row['Mail'];
            $Phone = $row['Phone'];
            $City = $row['City'];
            $Validation = $row['Validation'];
            $Password = $row['Password'];
            $sponsorshipCode = $row["sponsorshipCode"];
            $nbTrainers++;
            $link = '../CV/'.$sponsorshipCode.'.pdf';

            echo " 
      
          <tr>
          <td>$FirstName </td>
          <td> $Surname</td>
          
          <td>$Phone</td>
          <td>$City</td>
          
          <td style='padding-left:0;'> <button onclick=CVopen('$link') class='btn'>Voir</button></td>
          <td style='padding-left:0;'><button class='btn' onclick='validation(this,$nbTrainers)' id='btnValidation'> 
          <input type='hidden' value='$ID' name ='ID' id='$nbTrainers'/>Valider</button></td>
          </tr>
    
         
       ";
           
    }

        echo "</table>";
    }


    ?>
</div>
<div class="container">

<h1>Voir informations sur un formateur</h1>
<form method='POST'action='recapTrainers.php' >

<input type="text" id="nom" placeholder="Nom" name="nom">
<input type="text" id="prenom" placeholder="Prenom" name="prenom">

<?php

echo "<input type='hidden' name='ID' value='$IDeduc'>"

?>



<button class="btnAdd btn" type="submit">AFFICHER INFORMATIONS</button>





</form>



</div>
<div class="container">

<h1>Ajoutez des offres</h1>


<?php echo "<form action='../modeles/addOffers.php?ID=$IDeduc' method='POST' class='form' id='form'>";?>

<select name="Subject" id="Subject" class="select">
              <option value="">Choissisez un sujet</option>
              
<?php

// affiche toutes les matieres inscrit dans la base de donné dans un selecteur
$sql2 = "SELECT * FROM namesubject";
$p2 = $co->query($sql2);
while ($row = $p2->fetch_assoc()) {
echo "<option value=".$row['nameSubject'].">".$row['nameSubject']."</option>";

}

echo "</select>";

?>    
              
</select>


<h3>Ajoutez un créneau</h3>

<select name="Formation" id="Formation" class="select">
<option value="">Choissisez une classe</option>

<?php

// affiche toutes les formations inscrite dans la base de donné dans un selecteur pour ajoutez un cours a cette classe
$sql2 = "SELECT * FROM formation";
$p2 = $co->query($sql2);
while ($row = $p2->fetch_assoc()) {
echo "<option value=".$row['nomFormation'].">".$row['nomFormation']."</option>";

}

echo "</select>";
echo "<input type='hidden' name='ID' value='$IDeduc'/>";
?>    
</select>
<div class="matin">
<label>de 8H a 12h</label>
<input type="radio" id="matin" name="hour">
</div>

<div class="apresmidi">
<label>de 13H a 16h</label>
<input type="radio" id="apresmidi" name="hour">

</div>
<input type="date" id="date" name="date">

</form>

<button class="btn" onclick="addNiche()">Ajoutez créneau</button>
<div id="placeNiche"></div>
<button id="btnAddOffers" class="btn" onclick="addOffers()">Ajoutez offres</button>
</div>

<div class="container">
      <h2>Ajouter un élève</h2>
        <form action="../modeles/addStudent.php" method="post">
            <input type="text" placeholder="Nom" name="Nom"/>
            <input type="text" name="Prenom" placeholder="Prénom" />
            <select name="formation" class="select">
            <option value="">Choissisez une classe</option>

            <?php
// affiche toutes les formations inscrite dans la base de donné dans un selecteur pour ajoutez un élève a un cours
$sql2 = "SELECT * FROM formation";
$p2 = $co->query($sql2);
while ($row = $p2->fetch_assoc()) {
echo "<option value=".$row['nomFormation'].">".$row['nomFormation']."</option>";

}

echo "</select>";
echo "<input type='hidden' name='ID' value='$IDeduc'/>";
?>
              



            <button class="btnAdd btn" onclick="addStudent()">Ajouter</button>
        </form>
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
<script type="text/javascript">
 nbNiche = 0;
document.getElementById('btnAddOffers').style.display = "none";
/*Fonction qui permet de validr un formateurs (trainer) 
quant l'admin clique sur un bouton une box d'alert s'affiche et lui dit de taper le mot 'comfirm' pour bien valider le formateu
une fois cela fait un formulaire est crée dynamiquement avec ces champs, c'est a dire l'id du formateurs a valider et est exécuté.

*/
    function validation(elementDom, nb) {

        var txt;
        var msg = prompt("Please enter comfirm:");
        if (msg == "comfirm") {
            alert("trainers validate")

            value = document.getElementById(nb).value
            var form = document.createElement("form")
            form.setAttribute('method', "POST")
            form.setAttribute('action', '../modeles/validateTrainer.php?ID='+(<?= json_encode($IDeduc); ?>))

            var IDTrainers = document.createElement('input')
            IDTrainers.setAttribute('type', 'hidden')
            IDTrainers.setAttribute('name', 'IDTrainers')
            IDTrainers.setAttribute('value', value)
            form.appendChild(IDTrainers)

            




            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

        } else {

            alert("Trainers no validate.");


        }
    }



    function addStudent(){
        alert("élève ajoutez")

    }


//cette fonction permet de crée une offres et de l'affiché sur la page mais pas de l'envoyé sur la base de donnée
    function addNiche(){
        subject = document.getElementById('Subject');
        formation = document.getElementById('Formation');
        date = document.getElementById('date');
        add = true;
        form = document.getElementById('form');


        if (subject.selectedIndex == 0) {
            subject.style.border = "1px solid red";
            add = false
        }else {subject.style.border = "none";}
        
        if (formation.selectedIndex == 0) {
            formation.style.border = "1px solid red";
            add = false
        }else {formation.style.border = "none";}
         
        if (date.value == "") {
            date.style.border = "1px solid red";
            add = false
        }else {date.style.border = "none";}

        if(add == false){

            alert("Please fill in the field (s) marked in red")
        }
        else{
            nbNiche++;
            var div = document.createElement("div");
            div.classList.add("details")
            div.id = nbNiche;

//A ce stade on crée un formulaire dynamiquement et on récupere toutes les informations que l'utilisateur a entrez avec l'heure du cours, la classe, la matière etc
            var FormationVal = document.createElement("input");
            FormationVal.setAttribute("name", "formation"+nbNiche);
            FormationVal.setAttribute("type", "hidden");
            FormationVal.setAttribute("value", document.getElementById('Formation').value);
            form.appendChild(FormationVal);


            var dateVal = document.createElement("input");
            dateVal.setAttribute("name", "date"+nbNiche);
            dateVal.setAttribute("type", "hidden");
            dateVal.setAttribute("value", document.getElementById('date').value);
            form.appendChild(dateVal);

if(document.getElementById('matin').checked == true){


    var hourVal = document.createElement("input");
            hourVal.setAttribute("name", "hour"+nbNiche);
            hourVal.setAttribute("type", "hidden");
            hourVal.setAttribute("value", "8");
            form.appendChild(hourVal);

            var minutesVal = document.createElement("input");
            minutesVal.setAttribute("name", "minutes"+nbNiche);
            minutesVal.setAttribute("type", "hidden");
            minutesVal.setAttribute("value", "00");
            form.appendChild(minutesVal);



            var durationVal = document.createElement("input");
            durationVal.setAttribute("name", "duration"+nbNiche);
            durationVal.setAttribute("type", "hidden");
            durationVal.setAttribute("value", "4");
            form.appendChild(durationVal);

}

else if(document.getElementById('apresmidi').checked == true) {

            var hourVal = document.createElement("input");
            hourVal.setAttribute("name", "hour"+nbNiche);
            hourVal.setAttribute("type", "hidden");
            hourVal.setAttribute("value", "13");
            form.appendChild(hourVal);

            var minutesVal = document.createElement("input");
            minutesVal.setAttribute("name", "minutes"+nbNiche);
            minutesVal.setAttribute("type", "hidden");
            minutesVal.setAttribute("value", "00");
            form.appendChild(minutesVal);



            var durationVal = document.createElement("input");
            durationVal.setAttribute("name", "duration"+nbNiche);
            durationVal.setAttribute("type", "hidden");
            durationVal.setAttribute("value", "3");
            form.appendChild(durationVal);


}
                
            
            
           

        
//La on ajoute les informations tapez par l'utilisateur dans un récap qui sera ensuite inserez dans la page
            var formation2 = document.createElement("p");
            formation2.innerHTML = document.getElementById('Formation').value;
            div.appendChild(formation2);

            var dateVal2 = document.createElement("p");
            dateVal2.innerHTML = document.getElementById('date').value;
            div.appendChild(dateVal2);

            if(document.getElementById('matin').checked == true){

                var matin2 = document.createElement("p");
                matin2.innerHTML = "8H00";
                div.appendChild(matin2);

                var durationMatin = document.createElement("p");
                durationMatin.innerHTML = "4H";
                div.appendChild(durationMatin);


            }

            if(document.getElementById('apresmidi').checked == true){

var apresmidi2 = document.createElement("p");
apresmidi2.innerHTML = "13H00";
div.appendChild(apresmidi2);

var durationApresmidi = document.createElement("p");
durationApresmidi.innerHTML = "3H";
div.appendChild(durationApresmidi);


}


           /* var supprimer = document.createElement("p");
            supprimer.innerHTML = "Supprimer";
            supprimer.classList.add("Premove")
            supprimer.style.marginBottom = "0px"

            div.appendChild(supprimer);

*/
            document.getElementById('placeNiche').appendChild(div);
            document.getElementById('btnAddOffers').style.display = "block";
          



        }

 




    }
//cette fonction sers a ajoutez une offres c'est a dire executez le formulaire qui as été crée dynamiquement et apres affichez un message de comfirmation que l'offres as bien été ajoutez
function addOffers(){
    var nbNicheVal = document.createElement("input");
            nbNicheVal.setAttribute("name", "nbNiche");
            nbNicheVal.setAttribute("type", "hidden");
            nbNicheVal.setAttribute("value", nbNiche);
            form.appendChild(nbNicheVal);
alert("votre offres a bien été publié")
    document.getElementById('form').submit();
}
function CVopen(URL){
    window.open(URL)
}
 


</script>