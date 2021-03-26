<?php

include '../models/dao.php';

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
    
    if(isset($_SESSION['bikeUpdated']) && $_SESSION['bikeUpdated'] == 'true')
        $_SESSION['bikeUpdated'] = 'false';
}

//Vérifie qu l'utilisateur est connecté et admin
if(isset($_SESSION) && $_SESSION['useIsAdmin'] == 1)
{
    if(isset($_POST['bikFoundDate']) && isset($_POST['bikFoundLocation']) && isset($_POST['bikBrand']) && isset($_POST['color']) && isset($_POST['bikSerialNumber']) && isset($_POST['bikHeight']) && isset($_POST['bikIsElectric']))
    {
        //Insérer les variables passées en POST dans des variables séparées
        $bikeFoundDate = htmlspecialchars($_POST['bikFoundDate']);
        $bikFoundLocation = htmlspecialchars($_POST['bikFoundLocation']);
        $bikBrand = htmlspecialchars($_POST['bikBrand']);
        $bikColor = htmlspecialchars($_POST['color']);
        $bikSerialNumber = htmlspecialchars($_POST['bikSerialNumber']);
        $bikHeight = htmlspecialchars($_POST['bikHeight']);
        $bikIsElectric = htmlspecialchars($_POST['bikIsElectric']);
        if(isset($_POST['bikRetrieveDate']))
            $bikRetrieveDate = htmlspecialchars($_POST['bikRetrieveDate']);
        else
            $bikRetrieveDate = NULL;
        /////////////////////////////////////////////////////////////////

        //Get l'id dans l'url
        htmlspecialchars($idBike = $_GET['id']);

        $dao = new Database();

        //Exécute la fonction pour mettre à jour le vélo
        $dao->UpdateBike($idBike, $bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $bikRetrieveDate);

        $_SESSION['bikeUpdated'] = 'true';

        //Redirige sur la page de modification du vélo
        header("location: ../views/modifyBike.php?id={$idBike}");
    }
}
else
{
    //Redirige sur la page principale
    header("location: ../views/mainPage.php");
}


?>