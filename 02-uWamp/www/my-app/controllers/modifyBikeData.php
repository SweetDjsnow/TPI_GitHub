<?php

include '../models/dao.php';

session_start();

if(isset($_SESSION) && $_SESSION['useIsAdmin'] == 1)
{
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
    htmlspecialchars($idBike = $_GET['id']);

    $dao = new Database();

    $dao->UpdateBike($idBike, $bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $bikRetrieveDate);

    header("location: ../views/modifyBike.php?id={$idBike}");
}
else
{
    header("location: ../views/mainPage.php");
}

var_dump($_POST);

?>