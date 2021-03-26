<?php

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}

$resultsPerPage = "3";

if(isset($_SESSION))
{
    if(isset($_SESSION['isConnected']) && !empty($_SESSION['isConnected']))
    {
        if(isset($_POST) && !empty($_POST))
        {
            if(isset($_GET['page']))
                $page=$_GET['page'];
            else
                $page=null;

            if (!$page) 
            {
                $pc = "1";
            } else 
            {
                $pc = $page;
            }

            $begin = $pc-1;
            $begin = $begin * $resultsPerPage;

            include '../models/dao.php';

            $dao = new Database();

            $_SESSION['lastSearch'] = $_POST;

            $result = $dao->SearchInDatabase($_POST, $begin, $resultsPerPage);

            $numberOfResults = $dao->CountAllResults($_POST);


            include '../views/resultPage.php';
        }
        else
        {
            if(isset($_SESSION['lastSearch']))
            {
                if(isset($_GET['page']))
                    $page=$_GET['page'];
                else
                    $page=null;

                if (!$page) 
                {
                    $pc = "1";
                } else 
                {
                    $pc = $page;
                }

                $begin = $pc-1;
                $begin = $begin * $resultsPerPage;

                include '../models/dao.php';

                $dao = new Database();

                $result = $dao->SearchInDatabase($_SESSION['lastSearch'], $begin, $resultsPerPage);

                $numberOfResults = $dao->CountAllResults($_SESSION['lastSearch']);

                

                include '../views/resultPage.php';
            }
            else
            {
                header("location: ../views/mainPage.php");
            }
        }
    }
    else
    {
        header("location: ../views/index.php");
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