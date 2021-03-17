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
            if(isset($_POST['retriever']) && isset($_POST['giver']))
            {
                if(!empty($_POST['retriever']) && !empty($_POST['giver']))
                {
                    include '../models/dao.php';

                    $dao = new Database();

                    $date = date('Y-m-d');

                    $id = htmlspecialchars($_GET['id']);

                    $dao->SetReceiverAndGiverOfBike($id, $_POST['retriever'], $_POST['giver'], $date);
                
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