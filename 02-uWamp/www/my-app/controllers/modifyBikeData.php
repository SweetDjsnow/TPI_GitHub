<?php

include '../models/dao.php';

$bikeFoundDate = $_POST['bikFoundDate'];
$bikFoundLocation = $_POST['bikFoundLocation'];
$bikBrand = $_POST['bikBrand'];
$bikColor = $_POST['color'];
$bikSerialNumber = $_POST['bikSerialNumber'];
$bikHeight = $_POST['bikHeight'];
$bikIsElectric = $_POST['bikIsElectric'];
$idBike = $_GET['id'];

$dao = new Database();

$dao->UpdateBike($idBike, $bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric);

var_dump($_POST);

?>