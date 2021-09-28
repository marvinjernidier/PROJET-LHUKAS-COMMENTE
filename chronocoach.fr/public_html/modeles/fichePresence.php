<?php
//Synthaxe particulière pour crée un PDF avec Mpdf
require_once('../bd/connect.php');
session_start();


$IDtrainers = $_SESSION["IDtrainers"];


$sql = "SELECT * FROM trainers WHERE IDtrainers='$IDtrainers'";
$p1 = $co->query($sql);
while ($row = $p1->fetch_assoc()) {
    $FirstName = $row['FirstName'];
    $Surname = $row['Surname'];
    $Mail = $row['Mail'];
    $Phone = $row['Phone'];
    $sponsorshipCode = $row["sponsorshipCode"];
}


$formation = $_POST['formation'];
$name = $_POST['name'];
$ID = $_POST['id'];

$date = $_POST['date'];
$nbStudent = $_POST['nbStudent'];
$module = $_POST['module'];


echo $name;

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();



$stylesheet = file_get_contents('../css/fichePDF.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

$data = "
<table class='tete'>
<tr> 
<th><img class='teteImg' src='../photo/fore.jpg'></th>
<th>Fiche de présence journalière</th>
<th><p>EN-26</p><p>Ref. PO-01</p><p>GS/FC/16/24/02</p></th>
</tr>
</table>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);

$data = "
<a style='margin-bottom:15px'><strong>Nom du formateur : </strong></a><a>$name<a>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);
$data = "
<a style='margin-bottom:15px'><strong>Filière : </strong></a><a>$formation<a>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);
$data = "
<a style='margin-bottom:15px'><strong>Module : </strong></a><a>$module<a>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);

$data = "
<a style='margin-bottom:15px'><strong>Date : </strong></a><a>$date<a>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<table class='detailsOffers'>
<tr> 
<th rowspan='2'>Nom-Prenom du stagière</th>
<th colspan='2'>EMARGEMENT</th>
</tr>
<tr>
    <th>Matin<p>de 8H à 12H </p></th>
    <th>Apres-midi <p>de 13H à 16H </p></th>
  </tr>
  ";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);

for ($i = 1; $i <= $nbStudent; $i++) {

  $name = $_POST['name'.$i];

  $mpdf->WriteHTML("<tr><td >".$name."</td>", \Mpdf\HTMLParserMode::HTML_BODY);

    if($_POST['matin'.$i] == 'true' ){
      $mpdf->WriteHTML( "<td>X</td>", \Mpdf\HTMLParserMode::HTML_BODY);
    }
    else{
      $mpdf->WriteHTML( "<td></td>", \Mpdf\HTMLParserMode::HTML_BODY);
    }
 
    if($_POST['apresmidi'.$i]=="true"){
      $mpdf->WriteHTML( "<td>X</td>", \Mpdf\HTMLParserMode::HTML_BODY);
      
    }
    else{
      $mpdf->WriteHTML( "<td></td>", \Mpdf\HTMLParserMode::HTML_BODY);
    }

  


    $mpdf->WriteHTML("</tr>", \Mpdf\HTMLParserMode::HTML_BODY);

}

$data="</table>";
$mpdf->WriteHTML($data, \Mpdf\HTMLParserMode::HTML_BODY);




if ($_POST['seconde'] == 1){
    $sql = "UPDATE offerssecond SET fichePresence = 1  WHERE IDofferSeconde = $ID";
    $p1 = $co->query($sql);
}
else if ($_POST['seconde'] == 0)
{

  $sql = "UPDATE offers SET fichePresence = 1  WHERE IDoffers = $ID";
  $p1 = $co->query($sql);

}



$link =$FirstName."-$Surname-$formation-$module-$date.pdf";
$link = str_replace(' ', '',$link);
$mpdf->Output("../Fiche-Présence/".$link, 'F');
$mpdf->Output($link, 'D');



?>






