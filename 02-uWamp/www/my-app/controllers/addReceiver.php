<?php

include '../models/dao.php';

$dao = new Database();

var_dump($_POST);

if(isset($_POST))
{
    if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['phoneNumber']))
    {
        if(isset($_POST['submitBtn']))
        {
            $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
            $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
            $phoneNumber = htmlspecialchars($_POST['phoneNumber'], ENT_QUOTES);

            $dao->AddReceiverToDb($firstName, $lastName, $email, $phoneNumber);

            $id = htmlspecialchars($_GET['id'], ENT_QUOTES);

            var_dump($id);

            //header("location: ../views/retrievePage.php?id={$id}");
        }
    }
}

?>