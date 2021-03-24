<?php

    include '../models/dao.php';

    $dao = new Database();

    if(session_status()== PHP_SESSION_NONE)
    {
        session_start();
    }


    /////////////Décode les paramètres de l'URL///////////
    $firstName = urldecode($_GET['firstName']);
    $lastName = urldecode($_GET['lastName']);
    $npa = urldecode($_GET['npa']);
    $email = urldecode($_GET['email']);
    $phoneNumber = urldecode($_GET['phoneNumber']);
    $cityName = urldecode($_GET['cityName']);
    $officeAddress = urldecode($_GET['officeAddress']);
    //////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////
    ////////////////////////CREATION DE L'UTLISATEUR///////////////////////


    ////////////Générer le username//////////////////
    $usernameFirstPart = strtolower(substr($firstName, 0, 2));

    $usernameLastPart = strtolower(str_replace(' ', '', $lastName));

    if(strlen(str_replace(' ', '', $lastName)) > 5)
    {
        $usernameLastPart = substr($usernameLastPart,0,5);
    }
    else
    {
        $usernameLastPart = substr($usernameLastPart,0,strlen($usernameLastPart));
    }
    ////////////////////////////////////////////////


    $usernameFull = $usernameFirstPart.'.'.$usernameLastPart;
    //Check si l'utilisateur est super-admin (admin du site)
    if(isset($_SESSION) && $_SESSION['useIsSuperAdmin'] == 1)
    {
        //Check si un utilisateur a déjà ce nom
        if(empty($dao->CheckIfUserAlreadyExist($usernameFull)))
        {
            //Génère un mot de passe aléatoire à 8 charactères
            $passwordPlain = random_password(8);
            //hash le mot de passe
            $hashedPwd = password_hash($passwordPlain, PASSWORD_DEFAULT);

            ////Exécute la fonction du model pour créer la ville
            $cityId = $dao->CreateCity($firstName,$lastName,$email,$phoneNumber,$cityName,$officeAddress,$npa);

            //Exécute la fonction pour crééer l'utilisateur "admin" de la commune
            $dao->CreateUserAdmin($usernameFull, $hashedPwd, $cityId[0]['idCity'], $firstName, $lastName, $phoneNumber, $email);

            ///////////////////Fin création username///////////////////////////
            ///////////////////////////////////////////////////////////////////


            //////////////Contenu du mail + headers////////////////
            $msg = "Votre demande d'ouverture de compte pour la commune {$cityName} a été acceptée !\r\n
                    Voici vos données de login :\r\n
                    Nom d'utilisateur : ".$usernameFull."\r\n
                    Mot de passe : ".$passwordPlain."\r\n";

            $name = "Found Your Bike";
            $from = "found.your.bike@outlook.fr";
            $to = $email;
            $subject = "Demande d'ouverture de compte Found Your Bike";

            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/plain; charset=utf-8\r\n";
            $headers .= "Content-Transfer-Encoding: 8bit\r\n";
            $headers .= "From: {$name} <{$from}>\r\n";
            $headers .= "Reply-To: <{$from}>\r\n";
            $headers .= "X-Mailer: PHP/".phpversion()."\r\n";
            ////////////////////////////////////////////////////////

            ////Envoi du mail de confirmation
            try
            {
                mail($to,$subject, $msg, $headers);
                echo 'mail envoyé';
            }
            catch(Exception $e)
            {
                echo 'FAIL : '.$e;
            }
        }
        else
        {
            echo "Le nom d'utilisateur existe déjà, action annulée !";
        }
    }
    else
    {
        header("location: ../views/mainPage.php");
    }


    ////Fonction qui génére un password aléatoire avec comme param la longueur du MDP////
    function random_password($length) {
        $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789!@#$";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
    //include './createUser.php';
?>