<?php


if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}


if(isset($_SESSION))
{
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

                    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
                    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
                    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
                    $phoneNumber = htmlspecialchars($_POST['phoneNumber'], ENT_QUOTES);

                    $dao->AddReceiverToDb($firstName, $lastName, $email, $phoneNumber);

                    $id = htmlspecialchars($_GET['id'], ENT_QUOTES);

                    var_dump($id);

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