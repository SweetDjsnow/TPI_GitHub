<?php

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}

if(isset($_SESSION))
{
    if(isset($_SESSION['isConnected']) && !empty($_SESSION['isConnected']))
    {
        if(isset($_POST))
        {
            include '../models/dao.php';

            $dao = new Database();

            $result = $dao->SearchInDatabase($_POST);

            $numberOfResults = count($result);


            include '../views/resultPage.php';
        }
    }
}


?>