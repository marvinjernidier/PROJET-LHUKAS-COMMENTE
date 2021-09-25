<?php

//require_once('../bd/connect.php');
//session_start();


//$IDtrainers = $_SESSION["IDtrainers"];


/*$sql = "SELECT * FROM trainers WHERE IDtrainers='$IDtrainers'";
$p1 = $co->query($sql);
while ($row = $p1->fetch_assoc()) {
    $FirstName = $row['FirstName'];
    $Surname = $row['Surname'];
    $Mail = $row['Mail'];
    $Phone = $row['Phone'];
    $sponsorshipCode = $row["sponsorshipCode"];
}

*/
$FirstName = "test";
$Surname = "test";
$name = "lhukas";
$dateDeb = "12-02-2001";
$dateFin = "12-02-2001";
$ville1 = "pap";
$ville2 = "abymes";
$ville3 = "moule";
$ResumeNomEntreprise = "MJ METRIX";
$ResumeNumEntreprise = "0652463381";
$ResumeWebEntreprise = "www.mjmetrix.com";
$ResumeActiviteEntreprise = "Finances & assurances";
$FacMail = "nelhomme.lhukas@gmail.com";
$FacEntreprise = "lulu entreprise";
$FacPrenom = "severine";
$FacNom = "nelhomme";
$FacNum = "0652463381";
$FicheGoogleMyBusiness = true;
$adresse = "30 rue des ardennes";
$CP = "91940";
$ville = "les ulis";
$Ouverture = "10H";
$Fermeture = "16H";

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();



$stylesheet = file_get_contents('facture.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

$data = "<img class='logoHaut' src='photo/logo.jpg' >
<div class='Info'>
<p id='nomP'> $FacNom $FacPrenom</p>
<p>$FacMail</p>
<p>$FacNum</p>
</div>

 ";

$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);



$data = "<table class='tableTete'>
<tr>
  <th colspan='2'>Facture</th>
  
</tr>
<tr>
  <td>Numéro de facture : </td>
  <td>Q6DSQ5DSQF </td>

</tr>
 <tr>
  <td>Date de facture</td>
  <td>06/07/2021</td>

</tr>

 <tr class='aPayer' >
  <td>A payer EUR</td>
  <td >200€</td>
  

</tr>
</table>";

$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);





$data = "
<table id='resumé'>
				
				<tr>
					<th colspan='2'>Durée de votre opération commerciale</th>

				</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr>
<td>Date de début</td>
<td id='resumeDateDeb'>$dateDeb</td>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);



$data = "
<tr>
					<td>Date de fin</td>
					<td id='resumeDateFin'>$dateFin</td>
				</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);





$data = "

<tr>
<th colspan='2'>Ville du référencement</th>
</tr>
<tr>
<td>Ville ( OBLIGATOIRE )</td>
<td id='ville1'>$ville1</td>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr>
<td>Seconde ville ( OPTIONNELLE )</td>
<td id='ville2'>$ville2</td>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);

$data = "
<tr>
<td>Troisième ville ( OPTIONNELLE )</td>
<td id='ville3'>$ville3</td>
</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


///////




$data = "
<tr>
					<th colspan='2'>Entreprise a référencer</th>
				</tr>
				<tr>
					<td>Le nom de l'entreprise</td>
					<td id='ResumeNomEntreprise'>$ResumeNomEntreprise</td>
				</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr>
					<td>Numéro de téléphone</td>
					<td id='ResumeNumEntreprise'>$ResumeNumEntreprise</td>
				</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr>
					<td>Adresse du site web</td>
					<td id='ResumeWebEntreprise'>$ResumeWebEntreprise</td>
				</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);


$data = "
<tr>
					<td>Type d'activité de votre entreprise</td>
					<td id='ResumeActiviteEntreprise'>$ResumeActiviteEntreprise</td>
				</tr>";
$mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);



if ($FicheGoogleMyBusiness == false) {

    $data = "
	<tr class='FicheGoogleMyBusiness'>
					<th colspan='2'>Fiche Google My bussiness</th>
				</tr>

				<tr class='FicheGoogleMyBusiness'>
					<td>Adresse</td>
					<td id='adresse'>$adresse</td>
				</tr>";
    $mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);




    $data = "
    <tr class='FicheGoogleMyBusiness'>
    <td> Code postal</td>
    <td id='CP'>$CP</td>
</tr>";
    $mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);



    $data = "
	<tr class='FicheGoogleMyBusiness'>
					<td>Ville</td>
					<td id='ville'>$ville</td>
				</tr>";
    $mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);




    $data = "
	<tr class='FicheGoogleMyBusiness'>
					<th colspan='2'>Horaire</th>
				</tr>

				<tr class='FicheGoogleMyBusiness'>
					<td>Ouverture </td>
					<td id='Ouverture'>$Ouverture</td>
				</tr>";
    $mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);




    $data = "
	<tr class='FicheGoogleMyBusiness'>
					<td>Fermeture</td>
					<td id='Fermeture'>$Fermeture</td>
				</tr>";
    $mpdf->WriteHTML($data, Mpdf\HTMLParserMode::HTML_BODY);




}


$data = "</table>";
$mpdf->WriteHTML($data, \Mpdf\HTMLParserMode::HTML_BODY);

$data = "<table class='montant'>


<tr class='aPayer' >
<td>MONTANT TOTAL ( EUR ) </td>
<td >200€</td>


</tr>
</table>";
$mpdf->WriteHTML($data, \Mpdf\HTMLParserMode::HTML_BODY);








$link = "test.pdf";
$link = str_replace(' ', '', $link);
//$mpdf->Output($link, 'F');
$mpdf->Output($link, 'D');
