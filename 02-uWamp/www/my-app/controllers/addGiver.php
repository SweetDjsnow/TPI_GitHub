<?php

include '../models/dao.php';

$dao = new Database();

var_dump($_POST);

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];


$dao->AddGiverToDb($firstName, $lastName, $email, $phoneNumber);

$id = $_GET['id'];

var_dump($id);

//header("location: ../views/retrievePage.php?id={$id}");

?>