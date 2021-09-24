//Nombre de partie c'est a dire nombre de moment clé
nbPart = 0;


//fonction pour retirer la dernieres parties des moments clée
function removePart() {
  document.getElementById("Partie" + nbPart).remove();
  nbPart--;
  if (nbPart == 0){
    document.getElementById("btnRemove").style.display = "none";
  }
}


//fonction pour ajoutez un moment clé vidéo avec les vérifications qui vont avec c'est a dire que l'intervalle entre le debut et la fin sont supérieur a 10 secondes 
//( cette vérification est faire uniquement quant il y a plus d'un moment clé)
function addPart() {
  ajout = true;
  document.getElementById("btnRemove").style.display = "inline-block";
  if (nbPart > 0) {
    if (
      document.getElementById("name" + nbPart).value == "" ||
      document.getElementById("end" + nbPart).value == "00:00:01"
    ) {
      alert("veuillez remplir tout les champs  pour la partie" + nbPart);
      ajout = false;
    }
  }

  if (ajout) {
    nbPart++;
    //création des conteneur avec les informations que l'utilisateur aura inserer
    div = document.createElement("div");
    div.classList.add("details");
    div.id = "Partie" + nbPart;

    p = document.createElement("p");
    p.innerHTML = "Partie video" + nbPart;
    div.appendChild(p);
//conteneur pour le nom de la partie 
    var name = document.createElement("input");
    name.setAttribute("id", "name" + nbPart);
    name.setAttribute("placeholder", "Nom de cette partie");
    name.classList.add("namePart");
    name.setAttribute("type", "text");
    div.appendChild(name);
//création du conteneur pour le temps de départ
    var secondStart = document.createElement("input");
    secondStart.setAttribute("id", "start" + nbPart);
    secondStart.setAttribute("type", "time");
    // si le nombre de partie est égal a 1 le premier conteneur du temps de depart est initialisée a 1 seconde sinon il sera initialisé a la valeur que l'utilisateur aura rentré

    //vue que les input sont des type time donc il y a une synthaxe a respecter
    if (nbPart == 1) {
      secondStart.setAttribute("value", "00:00:01");
    } else {
      seconde =
        parseInt(
          document.getElementById("end" + (nbPart - 1)).value.split(":")[2]
        ) + 1;
      if (seconde < 10) {
        seconde = "0" + seconde;
      }
      
      if (isNaN(seconde)) {
        seconde = "01"
        
      }


      secondStart.setAttribute(
        "value",
        document.getElementById("end" + (nbPart - 1)).value.split(":")[0] +
          ":" +
          document.getElementById("end" + (nbPart - 1)).value.split(":")[1] +
          ":" +
          seconde
      );
    }

    secondStart.setAttribute("readonly", true);
    div.appendChild(secondStart);

    var secondEnd = document.createElement("input");
    secondEnd.setAttribute("id", "end" + nbPart);
    secondEnd.setAttribute("type", "time");
   
      secondEnd.setAttribute("value", "00:00:01");
    
    div.appendChild(secondEnd);
    document.getElementById("totalPart").appendChild(div);
  }
}




// cette fonction sert a generer les donnée structurée
function start() {
  valide = true;

  //vérification de l'url entré par l'utilisateur
  url = document.getElementById("url").value;
  var reg = /[v]=/gm;
  var testURL = reg.test(url);


  //l'url est analysée et découpé pour en extraire l'id de la vidéo
  if (testURL == true) {
    url = url.split("=");
    id = url[1].split("&");
    id = id[0];
  } else {
    url = url.split("/");
    id = url[3].split("?");
    id = id[0];
  }

  for (i = 1; i <= nbPart; i++) {
    debut =
      document.getElementById("start" + i).value.split(":")[0] * 3600 +
      document.getElementById("start" + i).value.split(":")[1] * 60 +
      document.getElementById("start" + i).value.split(":")[2];

    fin =
      document.getElementById("end" + i).value.split(":")[0] * 3600 +
      +(document.getElementById("end" + i).value.split(":")[1] * 60) +
      document.getElementById("end" + i).value.split(":")[2];

    if (fin - 10 <= debut) {
      alert("la durée de la partie " + i + " est inferieur a 10 seconde");
      valide = false;
    }
  }
  if (valide == true) {

    // récupération des donnée de la vidéo youtube grace a L'API YOUTUBE

    // les donnée structurée on une synthaxe particuliere du coup les seules variables qui change sont les donnée entrée par l'utilisateur et les informations liée a la vidéo
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        VideoInfo = JSON.parse(this.responseText);

        if (VideoInfo.pageInfo.resultsPerPage == 1) {
          videoJSON = "<script type='application/ld+json'>{\n";
          videoJSON +=
            "'@context': 'http://schema.org',\n" +
            "'@type': 'VideoObject',\n" +
            "'name': '" +
            VideoInfo.items[0].snippet.title.replace(/'/gi, "§") +
            "',\n" +
            "'description': '" +
            VideoInfo.items[0].snippet.description
              .replace(/'/gi, "§")
              .replace(/"/gi, "§") +
            "',\n" +
            "'thumbnailUrl':'" +
            VideoInfo.items[0].snippet.thumbnails.default.url +
            "',\n" +
            "'uploadDate': '" +
            VideoInfo.items[0].snippet.publishedAt +
            '"\,\n' +
            "'duration': '" +
            VideoInfo.items[0].contentDetails.duration +
            "',\n" +
            "'embedUrl': 'https://www.youtube.com/embed/" +
            id +
            "',\n" +
            "'interactionCount': '" +
            VideoInfo.items[0].statistics.viewCount +
            "'";

          for (i = 1; i <= nbPart; i++) {
            if (i == 1) {
              videoJSON += ",\n'hasPart':[";
              document.getElementById("start" + i).value.split(":")[2] = "00";
            }
            if (document.getElementById("name" + i).value != "") {
              videoJSON +=
                "{\n'@type':'Clip',\n" +
                "'name': '" +
                document
                  .getElementById("name" + i)
                  .value.replace(/'/gi, "§") +
                "',\n" +
                "'startOffset':";
              if (nbPart == 1) {
                videoJSON += 0;
              } else {
                videoJSON +=
                  document.getElementById("start" + i).value.split(":")[0] *
                    3600 +
                  document.getElementById("start" + i).value.split(":")[1] *
                    60 +
                  document.getElementById("start" + i).value.split(":")[2];
              }

             if (typeof document.getElementById("end" + i).value.split(":")[2] === 'undefined'){

              secondeENDCalcul = 0
             }
             else {
              secondeENDCalcul = document.getElementById("end" + i).value.split(":")[2]
             }
              videoJSON +=
                ",\n" +
                "'endOffset':" +
                document.getElementById("end" + i).value.split(":")[0] *
                  3600 +
                document.getElementById("end" + i).value.split(":")[1] * 60 +
                secondeENDCalcul +
                ",\n" +
                "'url':' https://www.youtube.com/watch?v=" +
                id +
                "?t=" +
                document.getElementById("end" + i).value.split(":")[0] *
                  3600 +
                document.getElementById("end" + i).value.split(":")[1] * 60 +
                secondeENDCalcul +
                "' \n";
              videoJSON += "}\n";
            }else{
              alert("Nom de la partie numéro :"+i+" est vide, donc il n'as pas été renseigné dans le code")
            }

            if (i != nbPart) {
              videoJSON += ",";
            }
          }
          if (nbPart > 0) {
            videoJSON += "]";
          }

          videoJSON +=
            ",\n'publisher': {\n" +
            "'@type': 'Organization',\n" +
            "'name': '" +
            VideoInfo.items[0].snippet.channelTitle.replace(/'/gi, "§") +
            "'\n" +
            "}";

          videoJSON += "\n}<";
          videoJSON += "/script>";

          videoJSON = videoJSON.replace(/'/gi, '"');
          videoJSON = videoJSON.replace(/§/gi, "'");
          document.getElementById("videoJSON").innerHTML = videoJSON;

          ////////////////////// Structure pour le format MicroData

          videoMicro =
            "<div itemprop='video' itemscope itemtype='http://schema.org/VideoObject'>\n" +
            "<h2><span itemprop='name'>" +
            VideoInfo.items[0].snippet.title.replace(/'/gi, "§") +
            "</h2>\n" +
            "<meta itemprop='duration' content='" +
            VideoInfo.items[0].contentDetails.duration +
            "' />\n" +
            "<meta itemprop='uploadDate' content='" +
            VideoInfo.items[0].snippet.publishedAt +
            "' />\n" +
            "<meta itemprop='thumbnailURL' content='" +
            VideoInfo.items[0].snippet.thumbnails.default.url +
            "' />\n" +
            "<meta itemprop='interactionCount' content='" +
            VideoInfo.items[0].statistics.viewCount +
            "' />\n" +
            "<meta itemprop='embedURL' content='https://www.youtube.com/embed/" +
            id +
            "' />\n" +
            "<div id='schema-videoobject' class='video-container'>" +
            "<iframe width='853' height='480' src='https://www.youtube.com/embed/" +
            id +
            "?rel=0&amp;controls=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>\n" +
            "</div>\n" +
            "<span itemprop='description'>" +
            VideoInfo.items[0].snippet.description.replace(/'/gi, "§") +
            "</span>\n" +
            "</div>\n";

          videoMicro = videoMicro.replace(/'/gi, '"');
          videoMicro = videoMicro.replace(/§/gi, "'");
          document.getElementById("videoMicroData").innerHTML = videoMicro;
        } else {
          alert("aucun vidéo n'as été trouvée avec cette url");
          document.getElementById("videoJSON").innerHTML = "";
        }
      }
    };
    xmlhttp.open(
      "GET",
      "https://www.googleapis.com/youtube/v3/videos?id=" +
        id +
        "&key=AIzaSyA4j_pDcBM8UMoR9bTHgensu2_PMwJgfKY&part=snippet,contentDetails,statistics,status",
      true
    );
    xmlhttp.send();
  }
}
//Fonction pour copier le texte a partir du bouton sur la page pour la partie donnée structurée en JSON
function copyDATA() {
  var copyText = document.getElementById("videoMicroData");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
  alert("Texte copié ");
}


//Fonction pour copier le texte a partir du bouton sur la page pour la partie donnée structurée en MicroData
function copyJSON() {
  var copyText = document.getElementById("videoJSON");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
  alert("Texte copié ");
}