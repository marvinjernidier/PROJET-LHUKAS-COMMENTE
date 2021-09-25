
///Simple requète AJAX pour contactez la base de donnée et vérifiée l'email et le mot de passe de l'utilisateur dans la base de donnée

function connexion() {
    InputValue = document.querySelectorAll("input");
    submit = true;
  
    for (i = 0; i < 2; i++) {
      if (InputValue[i].value == "") {
        InputValue[i].style.border = "1px solid red";
        submit = false;
      } else {
        InputValue[i].style.border = "2px solid #bdc3c7";
      }
    }
  
  
    if (submit) {
      
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == "1") {
           alert("connexion reussi");
           // window.location.href = "récapitulatif.php";
          } else {
            alert("mot de passe ou identifiant incorrect");
           
          }
        }
      };
      xmlhttp.open(
        "GET",
        "connexion.php?mail=" +
          document.getElementById("mail").value +
          "&mdp=" +
          document.getElementById("mdp").value
         
          ,true
      );
      xmlhttp.send();
    }
  }

  function showMDP() {
    InputValue = document.querySelectorAll("input");
  
   
      if (InputValue[1].type === "password") {
        InputValue[1].type = "text";
      } else {
        InputValue[1].type = "password";
      }
    
  }
  