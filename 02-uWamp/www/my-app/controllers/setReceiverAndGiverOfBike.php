<?php

include '../models/dao.php';

$dao = new Database();

var_dump($_POST);
var_dump($_GET);

$dao->SetReceiverAndGiverOfBike($_GET['id'], $_POST['retriever'], $_POST['giver']);

?>