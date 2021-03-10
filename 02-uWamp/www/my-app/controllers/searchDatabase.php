<?php

include '../controllers/checkIfConnected.php';

include '../models/dao.php';

$dao = new Database();

$result = $dao->SearchInDatabase($_POST);

$numberOfResults = count($result);


include '../views/resultPage.php';


?>