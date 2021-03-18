<?php

///Si la session n'a pas été démarrée, la démarre
if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}


///Check si la variable de session a été set et n'est pas vide
if(isset($_SESSION) && !empty($_SESSION))
{
    //Si le username est set et n'est pas vide
    if(isset($_SESSION['useUsername']) && !empty($_SESSION['useUsername']))
    {  
        //Check si l'utilisateur connecté n'est pas un admin
        if($_SESSION['useIsAdmin'] != 1)
        {
            //Si l'utilisateur est connecté mais n'est pas admin, le renvoie sur la page principale (après connexion)
            if($_SESSION['isConnected'] == 1)
                header("location: ../views/mainPage.php");
            //Si il ne l'est pas, le renvoie sur la page de login
            else
                header("location: ../views/index.php");
        }
    }
    else
    {
        session_destroy();
    
        header("location: ../views/index.php");
    }
}
else
{
    session_destroy();
    
    header("location: ../views/index.php");
}



?>