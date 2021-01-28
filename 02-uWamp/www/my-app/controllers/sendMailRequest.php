<?php

$to = "michel.dossantos@eduvaud.ch";

$subject = "Demande d'ajout pour ".$_POST['cityName'];

$msg = base64_encode("Demande de création de compte pour ".$_POST['cityName']."\r\n
Prénom : ".$_POST['firstName']."\r\n
Nom : ".$_POST['lastName']."\r\n
Email : ".$_POST['email']."\r\n
Numero de téléphone : ".$_POST['phoneNumber']."\r\n
Addresse du bureau : ".$_POST['officeAddress']."\r\n
Code postal : ".$_POST['npa']."\r\n");

//$msg .= "Prénom : ".$_POST['firstName']."\r\n";
//$msg .= "Nom : ".$_POST['lastName']."\r\n";
//$msg .= "Email : ".$_POST['email']."\r\n";
//$msg .= "Numero de téléphone : ".$_POST['phoneNumber']."\r\n";
//$msg .= "Addresse du bureau : ".$_POST['officeAddress']."\r\n";
//$msg .= "Code postal : ".$_POST['npa']."\r\n";


$name = "Michel Dos Santos";
$from = "michel.dossantos@eduvaud.ch";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=utf-8\r\n";
$headers .= "Content-Transfer-Encoding: base64\r\n";
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