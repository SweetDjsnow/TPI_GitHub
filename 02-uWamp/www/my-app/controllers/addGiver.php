<?php

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}



//Vérifications de $POST, de la variable de session qui définit si l'utilisateur est admin
if(isset($_POST) && !empty($_POST))
{
    if(isset($_SESSION))
    {
        if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['phoneNumber']))
        {
            if($_POST['firstName'] != '' && $_POST['lastName'] != '' && $_POST['phoneNumber'] != '')
            {
                if(isset($_POST['submitBtn']))
                {
                    include '../models/dao.php';

                    $dao = new Database();

                    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
                    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
                    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
                    $phoneNumber = htmlspecialchars($_POST['phoneNumber'], ENT_QUOTES);


                    $dao->AddGiverToDb($firstName, $lastName, $email, $phoneNumber);

                    $id = htmlspecialchars($_GET['id'], ENT_QUOTES);

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
        header("location: ../views/index.php");
    }
}

?>