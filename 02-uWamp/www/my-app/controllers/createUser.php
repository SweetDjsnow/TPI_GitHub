<?php

session_start();

if(isset($_SESSION) && !empty($_SESSION))
{
    if($_SESSION['useIsSuperAdmin'] == 1)
    {
        echo "xyes";
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