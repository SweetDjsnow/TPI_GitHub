<?php

include '../controllers/checkIfConnected.php';

var_dump($_POST);

include '../models/dao.php';

$dao = new Database();

$result = $dao->SearchInDatabase($_POST);

include '../views/resultPage.php';


var_dump($result);

?>