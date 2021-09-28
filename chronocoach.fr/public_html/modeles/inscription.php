<?php
require_once('../bd/connect.php');


//Déclaration de certaines variables
$IDnewTrainers;
$Validation = false; 
//Pour cette variable un peu spécial qui changes en fonction des cas du code aller voir la page validationInscription dans le dossier vues
$foundMail=0;

$point = 10;


//Récupération de toutes les variables passé grace au formulaire

$FirstName = str_replace(' ', '-',ucwords($_POST["FirstName"]));
$Surname = str_replace(' ', '-',strtoupper($_POST["Surname"]));



$Mail = $_POST["Mail"];
$numberPhone = $_POST["Phone"];
if( $numberPhone[0] == "0"){
    $numberPhone = substr($numberPhone, 1, 10); 
}

$Phone = $_POST["prefix"].$numberPhone;


$City = $_POST["City"];
$Password = $_POST["Password"];
$CV = $_POST["file"];
$nbSubject = $_POST["nbSubject"];
$Subject1 = $_POST["Subject1"];
$sponsorshipCode = $_POST["sponsorshipCode"];
$yearsSubject1 = $_POST["yearsSubject1"];




//Comparaison avec les mails déja existant avec le mail envoyé depuis le formulaires et si le code parrain entrée est valide pour lui accordée des points supplémentaires.
$sql="SELECT * FROM trainers";
$p1 = $co->query($sql);
	while ($row = $p1->fetch_assoc() )  
	{
        if($row['Mail'] == $Mail) {
            $foundMail = 1;
        }
        else if($row['sponsorshipCode']==$sponsorshipCode){
            $point = 20;
        }
	}

    if($foundMail == 0) {
        $foundMail = 2;
        //Requète pour l'insertion du trainers
        $req= "INSERT INTO trainers (IDtrainers,FirstName,Surname,Mail,Phone,City,Validation,Password,sponsorshipCode,point)
        VALUES (null,'$FirstName','$Surname','$Mail','$Phone','$City','$Validation','$Password','0','$point')";
        $co->query($req);

        //Récuperation du dernier ID inserée
        $IDnewTrainers = $co->insert_id;

        //Création du code parain de l'utilisateur qui vient d'etre crée avec la premiere lettre de son nom, son nom de famille et son ID.
        $sponsorshipCodeSelf = $FirstName[0].$Surname.$IDnewTrainers;

        //Renommage du fichier insérée par l'utilisateur
        rename("../CV/".$CV,"../CV/". $sponsorshipCodeSelf.".pdf");

        //Ajout du code parrainage a la base de donnée pour le trainers spécifiée par son ID
        $sqlSponsors = "UPDATE trainers SET sponsorshipCode = '$sponsorshipCodeSelf'  WHERE IDtrainers = $IDnewTrainers";
        $pSponsors = $co->query($sqlSponsors);

        //Insertion du prémier sujet enseignée par le trainers
        $req2= "INSERT INTO subject (IDtrainers,Subject,NumberYears) VALUES ($IDnewTrainers,'$Subject1','$yearsSubject1')";
        $co->query($req2);
        //Définitions du message qui sera envoyé par SMS plus tard a l'equipe EDUC (les ADMIN)
        $message = "Un nouveau formateur c'est inscrit a la plateforme, il vient de la commune : $City et enseigne la matière suivante : $Subject1. ";

//Insertion du deuxième ou du deuxième et troisième sujet enseignée par le trainers.
    if($nbSubject== 2){
        $Subject2 = $_POST["Subject2"];
        $yearsSubject2 = $_POST["yearsSubject2"];
        $req3= "INSERT INTO subject (IDtrainers,Subject,NumberYears) VALUES ($IDnewTrainers,'$Subject2','$yearsSubject2')";
        $co->query($req3);
        $message = "Un nouveau formateur c'est inscrit a la plateforme, il vient de la commune : $City et enseigne les matières suivantes : $Subject1,$Subject2. ";
    }
    else if($nbSubject == 3){
        $Subject2 = $_POST["Subject2"];
        $yearsSubject2 = $_POST["yearsSubject2"];
        $req3= "INSERT INTO subject (IDtrainers,Subject,NumberYears) VALUES ($IDnewTrainers,'$Subject2','$yearsSubject2')";
        $co->query($req3); 
        

        $Subject3 = $_POST["Subject3"];
        $yearsSubject3 = $_POST["yearsSubject3"];
        $req4= "INSERT INTO subject (IDtrainers,Subject,NumberYears) VALUES ($IDnewTrainers,'$Subject3','$yearsSubject3')";
        $co->query($req4);
        $message = "Un nouveau formateur c'est inscrit a la plateforme, il vient de la commune : $City et enseigne les matières suivantes : $Subject1,$Subject2,$Subject3. ";
    }

//Envoie de mail a chaque personne de l'équipe EDUC
    $sqlEDUC="SELECT * FROM educ";
    $pEDUC = $co->query($sqlEDUC);

    while ($rowEDUC = $pEDUC->fetch_assoc() )  
	{
    ini_set( 'display_errors', 1 );
        error_reporting( E_ALL );
        $from = "support@chronocoach.fr";
        $to = $rowEDUC['mail'];
        $subject = "NOUVEAU FORMATEUR";
        $headers = "From:" . $from;
        mail($to,$subject,$message, $headers);
    }

    session_start();
            $_SESSION["IDtrainers"]=$IDnewTrainers;     
   
    }
 header("Location: ../vues/acceuil_connecte.html");    
    


    
    ?>