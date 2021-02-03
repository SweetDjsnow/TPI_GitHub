<?php

    include '../models/dao.php';

    $dao = new Database();

    $numberOfBikes = $dao->GetNumberOfBikes();
    $numberOfBikes = $numberOfBikes[0]['COUNT(*)'];
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Page Title</title>
    </head>
    <body>

        <div class="main-page-form">
                <?php 
                    echo "<h1 class='main-page-title'>Il y'a actuellement {$numberOfBikes} vélos dans la base de donnée</h1>"; 
                ?>
            <div class="form-buttons">
            <form action="../views/searchPage.php">
                <div class="search-btn">
                    <button>Rechercher</button>
                </div>
            </form>
            <form action="../views/addPage.php">
                <div class="add-btn">
                    <button>Insérer</button>
                </div>
            </form>
            </div>
        </div>
        

    </body>

</html>
<?php
session_start();

if(isset($_SESSION) && !empty($_SESSION))
{                                   
    echo "<h1>BIENVENUE ".$_SESSION['useUsername']." !!!!!!!!!!!</h1><br>";

    if($_SESSION['useIsAdmin'] == 1)
    {
        echo "<h2>Vous êtes administrateurs !</h2>";
    }
    if($_SESSION['useIsSuperAdmin'] == 1)
    {
        echo "<h3>... et super-admin !!!!</h3>";
    }
}
else
{
    header("location: ./index.php");
}





?>