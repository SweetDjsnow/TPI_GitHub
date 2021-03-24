<?php

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}

if(isset($_SESSION))
{
    if(isset($_SESSION['isConnected']) && !empty($_SESSION['isConnected']))
    {
        if(isset($_POST) && !empty($_POST))
        {
            include '../models/dao.php';

            $dao = new Database();

            $_SESSION['lastSearch'] = $_POST;

            $result = $dao->SearchInDatabase($_POST);

            $numberOfResults = count($result);


            include '../views/resultPage.php';
        }
        else
        {
            if(isset($_SESSION['lastSearch']))
            {
                include '../models/dao.php';

                $dao = new Database();

                $result = $dao->SearchInDatabase($_SESSION['lastSearch']);

                $numberOfResults = count($result);


                include '../views/resultPage.php';
            }
            else
            {
                header("location: ../views/mainPage.php");
            }
        }
    }
}
else
{
    header("location: ../views/index.php");
}


?>

<?php
            include '../views/footer.html';
        ?>