<?php

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}

if(isset($_SESSION))
{
    if(isset($_SESSION['isConnected']) && !empty($_SESSION['isConnected']))
    {
        if(isset($_POST))
        {
            if(isset($_POST['giver']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['phoneNumber']) && isset($_POST['buyProof']) && isset($_POST['idProof']))
            {
                if(!empty($_POST['giver']) && $_POST['firstName'] != '' && $_POST['lastName'] != '' && $_POST['phoneNumber'] != '' && $_POST['buyProof'] != ''&& $_POST['idProof'] != '')
                {
                    include '../models/dao.php';

                    $dao = new Database();

                    $date = date('Y-m-d');

                    $id = htmlspecialchars($_GET['id']);

                    //Récupère les attributs envoyés par le post
                    $firstName = htmlspecialchars($_POST['firstName'], ENT_QUOTES);
                    $lastName = htmlspecialchars($_POST['lastName'], ENT_QUOTES);
                    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
                    $phoneNumber = htmlspecialchars($_POST['phoneNumber'], ENT_QUOTES);
                    $idProof = htmlspecialchars($_POST['idProof'], ENT_QUOTES);
                    $buyProof = htmlspecialchars($_POST['buyProof'], ENT_QUOTES);

                    //Exécute la fonctione pour créer le receveur dans la base de données
                    $dao->AddReceiverToDb($firstName, $lastName, $email, $phoneNumber, $idProof, $buyProof);

                    $idReceiver = $dao->GetLastReceiverAddedToDb();

                    $dao->SetReceiverAndGiverOfBike($id, $idReceiver[0]['idReceiver'], $_POST['giver'], $date);
                
                    header("location: ../views/bikeDetails.php?id={$id}");
                }
            }
        }
    }
}
else
{
    echo "session not set";
}


?>