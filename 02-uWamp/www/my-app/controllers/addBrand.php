<?php

include '../controllers/checkIfConnectedAdmin.php';
include '../models/dao.php';

if(isset($_GET['brand']) && !empty($_GET['brand']))
{
    $brand = htmlspecialchars($_GET['brand']);
    $dao = new Database();
    if(strlen($brand) <= 50)
    {
        $dao->AddBrand($brand);
        $_SESSION['brandAdded'] = 'true';
        header("location: ../views/addPage.php");
    }
    else
    {
        echo "Le nom de la marque est trop long, 50 charactères maximum autorisés !";
    }
}

?>