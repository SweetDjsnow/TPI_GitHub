<?php

include '../controllers/checkIfConnected.php';

var_dump($_POST);

include '../models/dao.php';

$dao = new Database();

$result = $dao->SearchInDatabase($_POST);

$numberOfResults = count($result);


include '../views/resultPage.php';


?>