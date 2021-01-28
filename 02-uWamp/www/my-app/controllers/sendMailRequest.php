<?php

$to = "michel.dossantos@eduvaud.ch";
$subject = "TEST";
$msg = "First line of text\nSecond line of text";

$name = "Michel Dos Santos";
$from = "michel.dossantos@eduvaud.ch";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
$headers .= "From: {$name} <{$from}>\r\n";
$headers .= "Reply-To: <{$from}>\r\n";
$headers .= "X-Mailer: PHP/".phpversion()."\r\n";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

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