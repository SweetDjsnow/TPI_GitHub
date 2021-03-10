<?php

include '../models/dao.php';

session_start();


if(isset($_POST))
{
    echo "Post is set<br>";
    if(isset($_POST['submitBtn']))
    {
        echo "submit is set<br>";
        if(!empty($_POST['username'] && !empty($_POST['password'])))
        {
            echo "username is set and password is set<br>";
            //$hashedPwd = password_hash($_POST['password'],PASSWORD_DEFAULT);

            $dao = new Database();

            $foundUser = $dao->SearchUser($_POST['username']);


            if(!empty($foundUser))
            {
                if (password_verify($_POST['password'], $foundUser[0]['usePassword']))
                {

                    $_SESSION['useUsername'] = $foundUser[0]['useUsername'];
                    $_SESSION['useIsAdmin'] = $foundUser[0]['useIsAdmin'];
                    $_SESSION['useIsSuperAdmin'] = $foundUser[0]['useIsSuperAdmin'];
                    $_SESSION['isConnected'] = true;
                    echo "Connexion réussie !";
                    header('location: ../views/mainPage.php');
                }
                else
                {
                    $_SESSION['hasFailed'] = true;
                    //header("location: ../views/index.php");
                }
            }
            else
            {
                $_SESSION['hasFailed'] = true;
                //header("location: ../views/index.php");
            }
        }
    }
}

?>