<?php

include '../models/dao.php';

$dao = new Database();

$idBike = $_GET['id'];

$dao->ResetRecieverAndGiver($idBike);

header("location: ../views/modifyBike.php?id=".$idBike);

?>