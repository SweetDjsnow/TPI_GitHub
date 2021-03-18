<?php

include './checkIfConnectedAdmin.php';
include '../models/dao.php';

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
    $dao = new Database();
    $results = $dao->CheckIfBikeExists($_GET['id']);

    if($results[0]['COUNT(*)'] != 0)
    {
        $dao->DeleteBike($_GET['id']);
        header("location: ../controllers/searchDatabase.php");
    }
    else
    {
        echo "Le vélo n'existe pas !";
    }
}
else
{
    echo "ID incorrect !";
}






?>