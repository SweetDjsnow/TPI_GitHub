<?php

//Start la session si elle n'est pas déjà démarrée
if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}

//Vérifie que la session est set
if(isset($_SESSION))
{
    //Get l'id du vélo
    $id = htmlspecialchars($_GET['id'], ENT_QUOTES);
    //Vérifie que le post est set
    if(isset($_POST))
    {
        if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['phoneNumber']))
        {
            if(isset($_POST['submitBtn']))
            {
                if($_POST['firstName'] != '' && $_POST['lastName'] != '' && $_POST['phoneNumber'] != '')
                {
                    include '../models/dao.php';

                    $dao = new Database();

                    //Récupère les attributs envoyés par le post
                    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
                    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
                    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
                    $phoneNumber = htmlspecialchars($_POST['phoneNumber'], ENT_QUOTES);

                    //Exécute la fonctione pour créer le receveur dans la base de données
                    $dao->AddReceiverToDb($firstName, $lastName, $email, $phoneNumber);

                    
                    header("location: ../views/retrievePage.php?id={$id}");
                }
                else
                {
                    header("location: ../views/retrievePage.php?id={$id}");
                }
            }
            else
            {
                header("location: ../views/retrievePage.php?id={$id}");
            }
        }
        else
        {
            header("location: ../views/retrievePage.php?id={$id}");
        }
    }
    else
    {
        header("location: ../views/retrievePage.php?id={$id}");
    }
}
else
{
    header("location: ../views/index.php");
}

?>