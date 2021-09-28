<!DOCTYPE html>

<?php
session_start();

if(isset($_SESSION["IDtrainers"])){
  
  header("Location: vues/acceuil_connecte.html");
}

?>
<title>Index</title>
<link rel="stylesheet" href="css/home.css">
<meta charset="UTF-8">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Suez+One&display=swap" rel="stylesheet">
<html>
  <div class="topnav">
    <img class="logo"  src="photo/logo1.png">

   

    <a href="#organisme" class="direction">Organisateur de formations</a>
    <a  href="#formateurs" class="direction">FORMATEURS</a>

   <a id="connexion" class="aWhite" onclick="openLoginForm()">SE CONNECTER</a>
   <div class="popup-overlay"></div>
<div class="popup">
  <div class="popup-close" onclick="closeLoginForm()">×</div>
  <div class="form">
    <div class="avatar">
      <img src="photo/avatar.png" alt="">
    </div>
    <div class="header">
      Connexion formateur
    </div>
    <form >
      <input type="text" placeholder="Adresse-mail" id="mail" />
      <input type="password" placeholder="mot de passe" name="Password" id="password"/>
      
      <a>Voir mot de passe.</a>
      <input type="checkbox" onclick="showMDP()">
      
       <a id="reponse"></a>
    </form>
    
    <button class="aOrange" onclick="connexion()" id="btnCO">Comfirmer</button>
    <p class="message">Pas de compte? <a href="vues/inscription.html">Créer un compte!</a></p>
      <p class="message">Vous etes responsable pédagogique ? <a href="vues/connexionEDUC.html">Connectez-vous ici !</a></p>
   
  </div>
</div>
   
    <a  id="inscription" href="vues/inscription.html" class="aOrange" >S'INSCRIRE</a>
  </div>


  <div class="topnav2">
    <img class="logo"  src="photo/logo1.png">
    <div class="dropdown">
      <img class="menu"  src="photo/menu.png">

      <div class="dropdown-content">
        
    <a href="#organisme" class="direction">Organisateur de formations</a>
    <a  href="#formateurs" class="direction">FORMATEURS</a>
        <a id="" class="" onclick="openLoginForm()">SE CONNECTER</a>
      </div>
    </div>

    <div class="popup-overlay"></div>
<div class="popup">
  <div class="popup-close" onclick="closeLoginForm()">×</div>
  <div class="form">
    <div class="avatar">
      <img src="photo/avatar.png" alt="">
    </div>
    <div class="header">
      Connexion formateur
    </div>
    <form >
      <input type="text" placeholder="adresse-mail" id="mail2" />
      <input type="password" placeholder="mot de passe" name="Password" id="password2"/>
      
      <a>Voir mot de passe.</a>
      <input type="checkbox" onclick="showMDP2()">
      
       <a id="reponse2"></a>
    </form>
    
    <button class="aOrange" onclick="connexion2()" id="btnCO">Comfirmer</button>
    <p class="message">Pas de compte? <a href="vues/inscription.html">Créer un compte!</a></p>
      <p class="message">Vous etes responsable pédagogique ? <a href="vues/connexionEDUC.html">Connectez-vous ici !</a></p>
   
  </div>
</div>
  </div>

   
 
 





  <div class='containerWHITE'>
    <div class="introduction">
      <h1>Rejoignez chronocoach</h1>
      <p>La plateforme qui met en relation les organisme de formation et les formateurs en <strong>quelques clics</strong></p>
      <a  class="aOrange" href="">TROUVER UN FORMATEUR</a>
      <a   class="aWhite" href="">TROUVER UN TRAVAIL</a>
    
    </div>
    <div class="block2">
      <img id="photoContainerWhite" src="photo/introduction1.jpg">
    </div>
 
    




  </div>
  <div class='containerORANGE' id="organisme">

<div class="Introduction2"  >
<h2>Pour les organismes</h2>
<p>Chronocoach met directement en conctact vos responsables pédagogique avec de bon formateurs rapidement </p>
<p><strong>Que ce soit pour des remplacements urgents que pour une longue durée.</strong> </p>



</div>


  </div>

  


  

  <div class='containerWHITE2' id="formateurs">
    <div class="Introduction3">
      <h2>Pour les Formateurs </h2>
      <p>Chronocoach te permet de gagner de l'argent <strong>facilement et rapidement</strong> donnez
         des cours dans un centre de formation renommé en Guadeloupe.
      </p>

      <p>Une notification à accepter, et c'est parti pour la mission ! </p>
  
      
      
      </div>
    

  </div>

  <div class="footer">
 

    <div class="entreprise">
      <img class="logoFooter"  src="photo/logoMJmetrix.png">
      <p>Site réalisée par MJ METRIX</p>
      <p>Agence digitale en Guadeloupe & Martinique</p>
    </div>
    
   
    <div class="contact">
      
      <p>Rejoignez-nous sur les réseaux </p>
      <a onclick= 'window.open ("https://www.facebook.com/realmjmetrix")' ><img class="logoSocial"  src="photo/facebook.png"></a>
      <a onclick= 'window.open ("https://www.google.com/maps/place/MJ+Metrix+-+Agence+digitale+en+Guadeloupe/@16.241951,-61.5702357,17z/data=!3m1!4b1!4m5!3m4!1s0x8c13453310392ccf:0xd1bf5097a38d7599!8m2!3d16.241951!4d-61.568047")' ><img class="logoSocial"  src="photo/google.png"></a>
    </div>
  
  
  
  
  </div>
  

  </html>

  <script>
/*

Les 2 fonction suivante qui sont commence par connexion sont des requète ajax pour l'authentification de lu'utilisateur, 
la raison pour laquel il y en as 2 est que il y a 2 formulaire de connexion sur cette page du coup pour etre plus adaptatif avec chaque input j'ai crée 3 requete de connexion
C'est une requète AJAX normal sans particularité


*/
function connexion() {

  var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText ==  "error"){
          document.getElementById('reponse').innerHTML = "mot de passe ou adresse mail incorrect";
          
        }
        else{
          alert('connexion reussi');
          window.location.href = "vues/acceuil_connecte.html";
        }
       
      }
    };
    xmlhttp.open("GET", "modeles/connexion.php?mail="+document.getElementById('mail').value+"&mdp="+document.getElementById('password').value, true);
    xmlhttp.send();

}

function connexion2() {

var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText ==  "error"){
        document.getElementById('reponse2').innerHTML = "mot de passe ou adresse mail incorrect";
        
      }
      else{
        alert('connexion reussi');
        window.location.href = "vues/acceuil_connecte.html";
      }
     
    }
  };
  xmlhttp.open("GET", "modeles/connexion.php?mail="+document.getElementById('mail2').value+"&mdp="+document.getElementById('password2').value, true);
  xmlhttp.send();

}
 //les 2 fonction suivante servent a affiché le mot de passe en toute lettres, de passer le type de l'input de password a text
function showMDP() {

var x = document.getElementById("password");
if (x.type === "password") {
    x.type = "text";
} else {
    x.type = "password";
}

}

function showMDP2() {

var x = document.getElementById("password2");
if (x.type === "password") {
    x.type = "text";
} else {
    x.type = "password";
}

}

    function openLoginForm(){
      document.body.classList.add("showLoginForm");
    }
    function closeLoginForm(){
      document.body.classList.remove("showLoginForm");
    }
    </script>