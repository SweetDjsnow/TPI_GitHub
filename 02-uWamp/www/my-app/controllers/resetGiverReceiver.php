<?php

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}

//Vérifie qu l'utilisateur est connecté et admin
if(isset($_SESSION) && $_SESSION['useIsAdmin'] == 1)
{
    include '../models/dao.php';

    $dao = new Database();

    $idBike = htmlspecialchars($_GET['id']);

    //Exécute la fonction qui efface le donneur et le receveur et mets le vélo comme non-rendu
    $dao->ResetRecieverAndGiver($idBike);

    //Redirige sur la page de modification du vélo
    header("location: ../views/modifyBike.php?id=".$idBike);
}
else
{
    //Redirige sur la page principale
    header("location: ../views/mainPage.php");
}

?>