//Simple requète AJAX pour inscrire l'utilisateur

function inscription() {
  InputValue = document.querySelectorAll("input");
  submit = true;

  for (i = 0; i < 3; i++) {

    // si un des champs est vide un message d'erreur s'affiche
    if (InputValue[i].value == "") {
      InputValue[i].style.border = "1px solid red";
      submit = false;
    } else {
      InputValue[i].style.border = "2px solid #bdc3c7";
    }
  }
// comparaison des mots de passe 
  if (InputValue[3].value != InputValue[4].value) {
    InputValue[4].style.border = "1px solid red";
    alert("mot de passe non similaires");
    submit = false;
  } else {
    InputValue[4].style.border = "2px solid #bdc3c7";
  }
// requete AJAX pour l'inscription
  if (submit) {
    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "error") {
         console.log("mail déja prit");
        } else {
          alert("compte crée");
         
        }
      }
    };
    xmlhttp.open(
      "GET",
      "inscription.php?mail=" +
        document.getElementById("mail").value +
        "&mdp=" +
        document.getElementById("mdp").value
        +
        "&nom=" +
        document.getElementById("nom").value
        +
        "&prenom=" +
        document.getElementById("prenom").value
        ,true
    );
    xmlhttp.send();
  }
}

function showMDP() {
  InputValue = document.querySelectorAll("input");

  for (i = 3; i < 5; i++) {
    if (InputValue[i].type === "password") {
      InputValue[i].type = "text";
    } else {
      InputValue[i].type = "password";
    }
  }
}
