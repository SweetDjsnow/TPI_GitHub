<?php

var_dump($_POST);

///////////////////Données du formulaire////////////////////////
$firstname = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];
$officeAddress = $_POST['officeAddress'];
$npa = $_POST['npa'];
$cityName = $_POST['city'];
////////////////////////////////////////////////////////////////

/////////////Encode les strings afin de permettre les caractères spéciaux dans l'url/////////////////////
$firstname = urlencode($firstname);
$lastName = urlencode($lastName);
$phoneNumber = urlencode($phoneNumber);
$officeAddress = urlencode($officeAddress);
$cityName = urlencode($cityName);
/////////////////////////////////////////////////////////////////////////////////////////////////////////


//////////////Contenu du mail + headers (les données envoyées depuis le formulaire par l'utilisateur et le lien qui permet d'accepter la demande)//////////
$msg = "
AJOUT D'UN NOUVEAU COMPTE DE RECHERCHE POUR LA COMMUNE ".$_POST['city']."\r\n
=====================================================================================\r\n
Prénom : ".$_POST['firstName']."\r\n
Nom : ".$_POST['lastName']."\r\n
Email : ".$_POST['email']."\r\n
Numero de téléphone : ".$_POST['phoneNumber']."\r\n
Addresse du bureau : ".$_POST['officeAddress']."\r\n
Code postal : ".$_POST['npa']."\r\n
Accepter la demande ? : http://localhost/my-app/controllers/createUser.php?firstName={$firstname}&lastName={$lastName}&email={$email}&phoneNumber={$phoneNumber}&officeAddress={$officeAddress}&npa={$npa}&cityName={$cityName}";

$name = "Found Your Bike";
$from = "found.your.bike@outlook.fr";
$to = "found.your.bike@outlook.fr";
$subject = "Demande d'ajout de compte recherche pour ".$_POST['city'];

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=utf-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "From: {$name} <{$from}>\r\n";
$headers .= "Reply-To: <{$from}>\r\n";
$headers .= "X-Mailer: PHP/".phpversion()."\r\n";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// send email
try
{
    mail($to,$subject, $msg, $headers);
    echo 'mail envoyé';
}
catch(Exception $e)
{
    echo 'FAIL'.$e;
}

?>