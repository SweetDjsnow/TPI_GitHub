<?php


if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}

if(isset($_SESSION) && !empty($_SESSION))
{
    if(isset($_SESSION['useUsername']) && !empty($_SESSION['useUsername']))
    {
        if($_SESSION['useIsAdmin'] != 1)
        {
            header("location: ./index.php");
        }
    }
    else
    {
        session_destroy();
    
        header("location: ./index.php");
    }
}
else
{
    session_destroy();
    
    header("location: ./index.php");
}



?>