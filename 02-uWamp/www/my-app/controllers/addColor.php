<?php

include '../controllers/checkIfConnectedAdmin.php';
include '../models/dao.php';

if(isset($_GET['color']) && !empty($_GET['color']))
{
    $color = htmlspecialchars($_GET['color']);
    $dao = new Database();
    if(strlen($color) <= 30)
    {
        $dao->AddColor($color);
        $_SESSION['colorAdded'] = 'true';
        header("location: ../views/addPage.php");
    }
    else
    {
        echo "Le nom de la couleur est trop long, 30 charactères maximum autorisés !";
    }
}


?>