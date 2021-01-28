<?php

$to = "found.your.bike@outlook.fr";

$subject = "Demande d'ajout pour ".$_POST['cityName'];

///////////////////Données du formulaire////////////////////////
$firstname = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];
$officeAddress = $_POST['officeAddress'];
$npa = $_POST['npa'];
////////////////////////////////////////////////////////////////

$msg = "Prénom\r\n".$_POST['firstName']."
Nom\r\n".$_POST['lastName']."
Email\r\n".$_POST['email']."
Numero de téléphone\r\n".$_POST['phoneNumber']."
Addresse du bureau\r\n".$_POST['officeAddress']."
Code postal\r\n".$_POST['npa']."
Accepter la demande ? : http://localhost/my-app/controllers/createCity.php?firstName={$firstname}&lastName={$lastName}&email={$email}&phoneNumber={$phoneNumber}&officeAddress={$officeAddress}&npa={$npa}";

//$msg .= "Prénom : ".$_POST['firstName']."\r\n";
//$msg .= "Nom : ".$_POST['lastName']."\r\n";
//$msg .= "Email : ".$_POST['email']."\r\n";
//$msg .= "Numero de téléphone : ".$_POST['phoneNumber']."\r\n";
//$msg .= "Addresse du bureau : ".$_POST['officeAddress']."\r\n";
//$msg .= "Code postal : ".$_POST['npa']."\r\n";


$name = "Found Your Bike";
$from = "found.your.bike@outlook.fr";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=utf-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "From: {$name} <{$from}>\r\n";
$headers .= "Reply-To: <{$from}>\r\n";
$headers .= "X-Mailer: PHP/".phpversion()."\r\n";

// use wordwrap() if lines are longer than 70 characters
//$msg = wordwrap($msg,70);

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