<?php

include '../models/dao.php';

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}


//Vérifie si $_POST est set
if(isset($_POST))
{
    //Vérifie que l'utilisateur a bien appuyé sur le bouton
    if(isset($_POST['submitBtn']))
    {
        //Si le username et le mot de passe n'est pas vide
        if(!empty($_POST['username'] && !empty($_POST['password'])))
        {
            //$hashedPwd = password_hash($_POST['password'],PASSWORD_DEFAULT);

            $dao = new Database();

            //Recherche un utilisateur ayant le username passé dans le formulaire
            $foundUser = $dao->SearchUser($_POST['username']);

            //Si un utilisateur a été trouvé
            if(!empty($foundUser))
            {
                //Compare le mot de passe passé en paramètre avec le mot de passe hashé
                if (password_verify($_POST['password'], $foundUser[0]['usePassword']))
                {
                    //Mets le username, les bools définissant si l'utilisateur est admin / super-admin dans des variables de session
                    $_SESSION['useUsername'] = $foundUser[0]['useUsername'];
                    $_SESSION['useIsAdmin'] = $foundUser[0]['useIsAdmin'];
                    $_SESSION['useIsSuperAdmin'] = $foundUser[0]['useIsSuperAdmin'];
                    $_SESSION['isConnected'] = true;

                    $city = $dao->GetCityName($foundUser[0]['idCity']);

                    $_SESSION['useCity'] = $city[0]['citName'];
                    $_SESSION['idCity'] = $foundUser[0]['idCity'];

                    //Redirige sur la page principale du site
                    header('location: ../views/mainPage.php');
                }
                else
                {
                    $_SESSION['hasFailed'] = true;
                    //Si la comparaison ne réussis pas, redirige sur la page de login
                    header("location: ../views/index.php");
                }
            }
            else
            {
                $_SESSION['hasFailed'] = true;
                //Si aucun utilisateur n'a été trouvé, redirige sur la page de login
                header("location: ../views/index.php");
            }
        }
        else
        {
            $_SESSION['hasFailed'] = true;
            //Si le formulaire n'a pas été rempli en entier, redirige sur la page de login
            header("location: ../views/index.php");
        }
    }
}

?>