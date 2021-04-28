<?php

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}



    //Get l'ID du vélo et la met dans une variable
    $id = htmlspecialchars($_GET['id'], ENT_QUOTES);
    //Vérifie que la session est set
    if(isset($_SESSION))
    {
        //Vérifie que les données du POST sont toutes set
        if(isset($_GET['firstName']) && isset($_GET['lastName']) && isset($_GET['email']) && isset($_GET['phoneNumber']))
        {
            //Vérifie que les données du POST ne sont pas vides
            if($_GET['firstName'] != '' && $_GET['lastName'] != '' && $_GET['phoneNumber'] != '')
            {

                    include '../models/dao.php';

                    $dao = new Database();

                    $firstName = htmlspecialchars($_GET['firstName'], ENT_QUOTES);
                    $lastName = htmlspecialchars($_GET['lastName'], ENT_QUOTES);
                    $email = htmlspecialchars($_GET['email'], ENT_QUOTES);
                    $phoneNumber = htmlspecialchars($_GET['phoneNumber'], ENT_QUOTES);


                    $dao->AddGiverToDb($firstName, $lastName, $email, $phoneNumber);

                    

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

?>