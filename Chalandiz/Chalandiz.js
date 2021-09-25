/*

Certaines valeur des input sont séparé par un ' : ' pour optimiser le code.
De ce faite par exemple pour le input quant l'utilisateur choisi une ville la valeur de l'input sera de cette forme 

value="ville:prix"     du coup pour récuperer la bonne valeur qu'on veux on utilise un split au niveau du code.



*/

function test(){
  console.log("ok")
  document.getElementById("mois").innerHTML = "decembre"
}
//Initialisation des variables
SelectValue = document.querySelectorAll("select");
for (i=0;i<4;i++){
  SelectValue[i].selectedIndex = "0";
}
PrixTotal = 0;
DateFin = new Date();
Nbjours = 0;
PrixTotal1 = 75
FicheGoogle = true
Elargissement = 0;
mois = [
  " ",
  "Janvier",
  "Février",
  "Mars",
  "Avril",
  "Mai",
  "Juin",
  "Juillet",
  "Août",
  "Septembre",
  "Octobre",
  "Novembre",
  "Décembre",
];
dateToday = new Date(Date.now())
valueDateToday = null
valueDateToday = dateToday.getFullYear()




if((dateToday.getMonth()+1)<10){
  valueDateToday += "-0"+(dateToday.getMonth()+1)


}
else {

  valueDateToday += "-"+ (dateToday.getMonth()+1)
}


if((dateToday.getDate()+1)<10){
  valueDateToday += "-0"+(dateToday.getDate()+1)

}
else {

  valueDateToday += "-"+ (dateToday.getDate())
}




//Cette fonction sers a augmenter le prix en fonction des communes choisi et si l'utilisateur a cocher la case pour l'elargissement
function elargissement(checkbox){

  if(checkbox.checked == true){
    valeurVille = document.getElementById("selectPrincipale").value.split(":")[1]

    if(valeurVille == "Baie-Mahault (97122)" || valeurVille == "Pointe-à-Pitre (97110)" || valeurVille == "Pointe-à-Pitre (97110)" ){

    Elargissement = (PrixTotal1 * ((1 * 20) / 100));
    console.log(Elargissement)

    }
    

  }

}
//Cette fonction sers a affiché le contenue de la fiche Google si l'utilisateur a cocher et remplie celle-ci
function GMB(checkbox) {

  FicheGoogle = checkbox;

  if (FicheGoogle == 'false') {

    document.getElementById("checkboxTrue").style.display = "none";
    document.getElementById("checkboxFalse").style.display = "block";

  } else {

    document.getElementById("checkboxTrue").style.display = "block";
    document.getElementById("checkboxFalse").style.display = "none";
    next(5)

  }
}


//Cette fonction sers a mettre a jour le prix quant l'utilisateur a choisi son type d'entreprise
function updateType(Select) {
  if ((Select.value.split(":")[1] = !0)) {
    PrixTotal3 = PrixTotal2 + (PrixTotal2 * ((1 * Select.value.split(":")[1]) / 100));
    console.log(PrixTotal3);
  }
}


//Cette fonction sers a mettre a jour le prix quant l'utilisateur a choisi sa  ville
function updateCity(Select) {
  if ((Select.value.split(":")[1] = !0)) {
    PrixTotal2 = Elargissement + PrixTotal1 + (PrixTotal1 * ((1 * Select.value.split(":")[1]) / 100));
    console.log(PrixTotal2);
  }
}


// Les 5 fonctions suivante sers a remplir la fiche récapitulative qui ce trouve a la dernieres partie
function updateFacMail(input) {
  document.getElementById("FacMail").innerHTML = input.value;
}
function updateFacEntreprise(input) {
  document.getElementById("FacEntreprise").innerHTML = input.value;
}

function updateFacPrenom(input) {
  document.getElementById("FacPrenom").innerHTML = input.value;
}
function updateFacNom(input) {
  document.getElementById("FacNom").innerHTML = input.value;
}
function updateFacNum(input) {
  document.getElementById("FacNum").innerHTML = input.value;
}




//cette fonction sers a mettre a jour le prix quant l'utilisateur a choisi sa période de campagne
function updateDuration(input,jours,prix){

    Nbjours = jours;
    PrixTotal1 = prix;
    next(2)
    
}

function updateDate() {
}


// Cette fonction sers a amorcer et a affiché la prmière partie du formulaire
function start() {
  document.getElementById("Introduction").style.display = "none";
  document.getElementById("partie2").style.display = "block";
  document.getElementById("barProgress").value = 1;

  //vérification que une date a bien été choisi dans l'iframe qui sers office de input Date du coup on ajoute un évenement a celui-ci et on observe son comportement 
  //si l'utilisateur clique sur une date on récupere les informations liée a celle-ci sinon on lui envoie un message d'erreur
document.getElementsByTagName('Iframe')[0].contentWindow.document.getElementById('testipt').addEventListener("change", function(){
if(document.getElementsByTagName('Iframe')[0].contentWindow.document.getElementById('testipt').value == "")
{
  alert("Veuillez choisir une date")
}
else{
  dateDebut = new Date(document.getElementsByTagName('Iframe')[0].contentWindow.document.getElementById('testipt').value);
  document.getElementsByTagName('Iframe')[0].contentWindow.document.getElementById('testipt').value = 

  dateDebut.getDate() +
  " " +
  mois[dateDebut.getMonth() + 1] +
  " " +
  dateDebut.getFullYear()
 
//comfirmation demande pour passé a l'etape suivante
  var answer = window.confirm(

    "Etes vous sur du choix de la date de debut ? \n " +
    //MaVariable = "15,20,30"
    //MaVariable.split(",")[1] -> 20
      " " +
     // mois[parseInt(input.value.split("-")[1])] +
      " " //+
     // input.value.split("-")[0]
  );
  if (answer) {

    
    window.location.href = "#top";

    document.getElementById("introPartie2").innerHTML = "Sélectionnez la période de votre opération commerciale"
    document.getElementsByClassName("messageERROR")[0].style.display =
    "none";
    document.getElementById("containerDate").style.animation =
      "disparitionDate 0.55s";

    setTimeout(function () {
      document.getElementById("containerDate").style.display = "none";
    }, 500);

    setTimeout(function () {
      document.getElementById("containerOffers").style.display = "block";
    }, 500);
    

    
  }
}
}); 
}



/* cette fonction sert a retourner a l'étape précedentes en passant le conteneur de l'etape en display none et en passant le conteneur de 
l'epate précedente en block */
function previous(nbEtapes) {
  document.getElementById("partie" + nbEtapes).style.display = "none";
  document.getElementById("partie" + (nbEtapes - 1)).style.display = "block";

  document.getElementById("barProgress").value = nbEtapes - 2;
}

/*   

Cette fois-ci pareil sauf que c'est dans l'autre sens cette fonction sers à afficher le conteneur de l'étapes suivante
En fonction du numéro d'étapes et les informations que l'utilisateur a saisi différent message s'affiche

Si lors de l'appel de la fonction pour une étapes suivante l'utilisateur a oublier de remplir un ou plusieurs champs cette fonction controle cela et affiche aussi un message d'erreur
*/

function next(nbEtapes) {
  nextVal = true;

  SelectValue = document.querySelectorAll("select");

  switch (nbEtapes) {
    case 3:
        
      if ( document.getElementsByTagName("select")[0].selectedIndex == 0) {
        nextVal = false;
        document.getElementsByTagName("select")[0].style.border =
          "1px solid red";
        document.getElementsByClassName("messageERROR")[1].style.display =
          "block";
      } else {
        document.getElementsByClassName("messageERROR")[1].style.display =
          "none";
        document.getElementsByTagName("select")[0].style.border =
          "2px solid #bdc3c7";
      }

      break;

    case 4:
      etapes4 = document.getElementById("partie4").querySelectorAll("input");
      for (i = 0; i < 3; i++) {
        if (etapes4[i].value == "") {
          nextVal = false;
          etapes4[i].style.border = "1px solid red";
          document.getElementsByClassName("messageERROR")[2].style.display =
            "block";
        }
      }

      if ( document.getElementsByTagName("select")[3].selectedIndex == 0) 
      {
        nextVal = false;
        document.getElementsByTagName("select")[3].style.border = "1px solid red";
        document.getElementsByClassName("messageERROR")[2].style.display = "block";
        
      } 
      else {
        document.getElementsByClassName("messageERROR")[2].style.display = "none";
        document.getElementsByTagName("select")[3].style.border = "2px solid #bdc3c7";
      }

      if (nextVal) {
        document.getElementsByClassName("messageERROR")[2].style.display =
          "none";
        for (i = 0; i < 3; i++) {
          if (etapes4[i].value != "") {
            etapes4[i].style.border = "2px solid #bdc3c7";
          }
        }
      }
      break;

    case 5:
      /*
 si la fiche Google a été renseigné ou non il sera affiché dans le récapitulatif

*/
      if (FicheGoogle == 'false') {

        FGMB = document.getElementsByClassName("FicheGoogleMyBusiness");
        for (i = 0; i < 7; i++) {
          FGMB[i].style.display = "table-row";
        }

      }
      else{

        FGMB = document.getElementsByClassName("FicheGoogleMyBusiness");
        for (i = 0; i < 7; i++) {
          FGMB[i].style.display = "none";
        }

      }

      
/*

A partir de la toutes les informations saisi par l'utilisateur sont récupérer et son redirigé vers le récapitulatif

*/
     
      DateFin = new Date(dateDebut.getTime() + (86400000*Nbjours));
    
      document.getElementById("resumeDateDeb").value =
      dateDebut.getDate() +
        " " +
        mois[dateDebut.getMonth() + 1] +
        " " +
        dateDebut.getFullYear();
    
    
      /* document.getElementById("resumeDateFin").innerHTML =
        document.getElementById("dateFin").value;*/
    document.getElementById("resumeDateFin").value =
        DateFin.getDate() +
        " " +
        mois[DateFin.getMonth() + 1] +
        " " +
        DateFin.getFullYear();
    
    
    
      for (i = 0; i < 3; i++) {
        document.getElementById("ville" + (i + 1)).innerHTML =
          SelectValue[i].value.split(":")[0];
      }
    document.getElementById("PrixTotal").innerHTML = Math.round(PrixTotal3) + " €"
      document.getElementById("ResumeNomEntreprise").innerHTML =
        document.getElementById("nomEntreprise").value;
      document.getElementById("ResumeNumEntreprise").innerHTML =
        document.getElementById("numEntreprise").value;
      document.getElementById("ResumeWebEntreprise").innerHTML =
        document.getElementById("WebEntreprise").value;
      document.getElementById("ResumeActiviteEntreprise").innerHTML = document
        .getElementById("TypeEntreprise")
        .value.split(":")[0];
      PrixTotal = PrixTotal3;


      if(FicheGoogle == 'false'){

      INPUTficheGoogle = document.getElementById("checkboxFalse").querySelectorAll("input");
     document.getElementById("adresse").innerHTML = INPUTficheGoogle[0].value
     document.getElementById("CP").innerHTML = INPUTficheGoogle[1].value
     document.getElementById("ville").innerHTML = INPUTficheGoogle[2].value
      }
      break;

    default:
     
  }

  if (nextVal) {
    document.getElementById("partie" + nbEtapes).style.display = "none";
    document.getElementById("partie" + (nbEtapes + 1)).style.display = "block";
    document.getElementById("barProgress").value = nbEtapes;
  }

}
