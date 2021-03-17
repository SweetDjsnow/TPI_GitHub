<?php

//Si la session n'est pas encore démarrée, la démarre
if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}

//Si $SESSION est set et pas vide
if(isset($_SESSION) && !empty($_SESSION))
{
    //Si le username est set et pas vide
    if(isset($_SESSION['useUsername']) && !empty($_SESSION['useUsername']))
    {
        
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