<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* Exception class. */
require '../../../phpapps/phpmailer/src/Exception.php';

/* The main PHPMailer class. */
require '../../../phpapps/phpmailer/src/PHPMailer.php';

/* SMTP class, needed if you want to use SMTP. */
require '../../../phpapps/phpmailer/src/SMTP.php';

$email = new PHPMailer(TRUE);

?>