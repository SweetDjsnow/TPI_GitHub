<?php
var_dump($_POST);

include '../models/dao.php';

$dao = new Database();

$result = $dao->SearchInDatabase();
var_dump($result);

?>