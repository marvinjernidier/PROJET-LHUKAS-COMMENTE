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


$name = $_POST['name'];
$date = $_POST['date'];
$formation = $_POST['formation'];
$module = $_POST['module'];
$objectif = $_POST['objectif'];
$contenue = $_POST['contenue'];
$support = $_POST['support'];
$remarque = $_POST['remarque'];
$ID = $_POST['ID'];


require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();



$stylesheet = file_get_contents('../css/fichePDF.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

$data = "
<table class='tete'>
<tr> 
<th><img class='teteImg' src='../photo/fore.jpg'></th>
<th>FICHE JOURNALIERE ACTIVITE FORMATEUR</th>
<th><p>EN-26</p><p>Ref. PO-01</p><p>GS/FC/16/24/02</p></th>
</tr>
</table>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);



$data = "<a style='margin-bottom:15px'><strong>Nom du formateur : </strong></a><a>$name<a>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);

$data = "<a style='margin-bottom:15px'><strong>Filière : </strong></a><a>$formation<a>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "<a style='margin-bottom:15px'><strong>Module : </strong></a><a>$module<a>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);

$data = "<a style='margin-bottom:15px'><strong>Date : </strong></a><a>$date<a>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<table class='detailsOffers'>
<tr> 
<th>Objectif de la scéance</th>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr> 
<td>$objectif</td>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);



$data = "
<tr> 
<th>CONTENUE DE LA SCEANCE (cours,exercices et applications réalisés)</th>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr> 
<td>$contenue</td>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr> 
<th>SUPPORTS UTILISES</th>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr> 
<td>$support</td>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);

$data = "
<tr> 
<th>REMARQUES</th>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr> 
<td>$remarque</td>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);

$data="</table>";
$mpdf->WriteHTML($data, \Mpdf\HTMLParserMode::HTML_BODY);




if ($_POST['seconde'] == 1){
    $sql = "UPDATE offerssecond SET ficheActivite = 1  WHERE IDofferSeconde = $ID";
    $p1 = $co->query($sql);
}
else if ($_POST['seconde'] == 0)
{

  $sql = "UPDATE offers SET ficheActivite = 1  WHERE IDoffers = $ID";
  $p1 = $co->query($sql);

}


$link =$FirstName."-$Surname-$formation-$module-$date.pdf";
$link = str_replace(' ', '',$link);
$mpdf->Output("../Fiche-activité-formateur/".$link, 'F');
$mpdf->Output($link, 'D');