<?php

    include '../models/dao.php';

    $dao = new Database();

    $dao->CreateCity($_GET['firstName'],$_GET['lastName'],$_GET['email'],$_GET['phone'],$_GET['cityName'],$_GET['officeLocation'],$_GET['npa']);

    foreach($_GET as $parameters)
    {
        echo $parameters."<br>";
    }

    echo "<br><br>Création terminée";
?>