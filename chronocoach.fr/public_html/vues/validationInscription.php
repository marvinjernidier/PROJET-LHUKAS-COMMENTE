<!DOCTYPE html>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/inscription.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&family=Suez+One&display=swap" rel="stylesheet">
<html>
<div class="form" style="margin-top: 100px;">
  <?php

  $AddAccount = $_GET['AddAccount'];
  if ($AddAccount == 1) {
    echo "<h3>Adresse mail saisi est deja prise</h3>";
    echo "<button id='inscription' class='btn'>Retourner vers le formulaire d'inscription</button>";
  } 
  else if ($AddAccount == 2){
    echo "<h3>Votre compte a bien été créer</h3>";
    echo "<h4>Un mail a été envoyée a notre equipe, nous valideront votre compte dans les plus bref délais</h4>";
    echo "<button id='connexion' class='btn'>Se rediriger vers espace membres</button>";
  }
  else if ($AddAccount == 3) {
    echo "<h3>Adresse mail saisi est deja prise</h3>";
    echo "<button id='inscription' class='btn'>Retourner vers le formulaire d'inscription</button>";
  } 
  else if ($AddAccount == 4) {
    echo "<h3>Votre compte a bien été crée mais il semble qu'un autre compte sois déja connectée a notre platforme sur votre navigateur.</h3>";
    echo "<button id='connexion' class='btn'>Aller vers le formulaire de connexion</button>";
  } 
  else if ($AddAccount == 5) {
    echo "<h3>Votre compte a bien été créer</h3>";
    echo "<button id='connexion' class='btn'>Se rediriger vers la page EDUC admin</button>";
  } 




  ?>
</div>
</div>

</html>

<script type="text/javascript">
  var addAccount = (<?= json_encode($AddAccount); ?>);
  if (addAccount == 1) {
    document.getElementById("inscription").onclick = function() {
      location.href = "../vues/inscription.html";
    };

  } else if (addAccount == 2){
    document.getElementById("connexion").onclick = function() {
      location.href = "../vues/membre.php";
    };
  }
  else if (addAccount == 4){
    document.getElementById("connexion").onclick = function() {
      location.href = "../vues/connexion.html";
    };
  }

  else if (addAccount == 3) {
    document.getElementById("inscription").onclick = function() {
      location.href = "../vues/inscriptionEDUC.html";
    };
  }
    else if (addAccount == 5) {
      document.getElementById("connexion").onclick = function() {
      location.href = "../vues/admin.php";
    };
  }
  
  
</script>