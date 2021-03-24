<?php

    include '../controllers/checkIfConnected.php';
    include '../models/dao.php';
    include './navBar.php';

    $dao = new Database();

    ///Récupère le nombre total de vélos dans la base de données pour l'afficher sur la mainpage
    $numberOfBikes = $dao->GetNumberOfBikes();
    $numberOfBikes = $numberOfBikes[0]['COUNT(*)'];

    var_dump($numberOfBikes);

    /////Résultats des requêtes pour les statistiques
    $statsQuarter = $dao->GetBikesRetrievedByQuarter();
    $statsYear = $dao->GetBikesRetrievedByYear();

    

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
                <div>
                <img src="../img/bicycle_icon.png" class="main-page-icon">
                    <form action="../views/searchPage.php">
                        <div class="search-btn" <?php if($_SESSION['useIsAdmin'] == '0'){echo 'style="float: none; width: 100%;"';} ?>>
                            <button>Rechercher</button>
                        </div>
                    </form>
                    <?php 
                        ///N'affiche pas le bouton permettant d'annoncer des vélos si l'utilisateur n'est pas admin
                        if($_SESSION['useIsAdmin'] == '1')
                        {
                            echo '<form action="../views/addPage.php">
                                    <div class="add-btn">
                                        <button>Insérer</button>
                                    </div>
                                </form>';
                        }
                    ?>
                    
                </div>
            </div>
        </div>
        
        <div class="main-page-stats">
        <h1>Statistiques</h1>
                <div class="form-buttons">
                    <div>
                        <h2>Nombre de vélos rendus par trimestre</h2>
                        <table class="table-details">
                            <tr style="color: #439a47;">
                                <th>Année</th>
                                <th>Trimestre</th>
                                <th>Nombre de vélos rendus</th>
                            </tr>
                            <?php
                                //Boucle pour afficher les résultats des statistiques
                                foreach($statsQuarter as $key => $value)
                                {
                                    //Si la valeur de l'année ou du trimestre est NULL (vélos qui n'ont pas été rendus), n'affiche rien.
                                    if($value['year'] != NULL || $value['quarter'] != NULL)
                                    {
                                        echo "<tr class='table-stats-row'>
                                                <td>".$value['year']."</td>
                                                <td>".$value['quarter']."</td>
                                                <td>".$value['numberOfBikes']."
                                            </tr>";
                                    }
                                }
                            ?>
                        </table>
                        <h2>Nombre de vélo rendus par année</h2>
                        <table class="table-details">
                        <tr style="color: #439a47;">
                                <th>Année</th>
                                <th>Nombre de vélos rendus</th>
                            </tr>
                            <?php
                                //Boucle pour afficher les résultats des statistiques
                                foreach($statsYear as $key => $value)
                                {
                                    //Si la valeur de l'année est NULL (vélos qui n'ont pas été rendus), n'affiche rien.
                                    if($value['year'] != NULL)
                                    {
                                        echo "<tr class='table-stats-row'>
                                                <td>".$value['year']."</td>
                                                <td>".$value['numberOfBikes']."
                                            </tr>";
                                    }
                                }
                            ?>
                        </table>
                        
                    </div>
                </div>
                
        </div>
        
        

    </body>

    <?php
            include '../views/footer.html';
        ?>

</html>

