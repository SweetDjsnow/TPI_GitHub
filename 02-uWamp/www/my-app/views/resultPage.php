<?php

include '../controllers/checkIfConnected.php';
$photosDir = '../img/bike_photos/';
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Résultats</title>
    </head>
    <body>
        <h1>Résultats</h1>
            <div class="all-result-div">
                <?php
                    foreach($result as $key => $value)
                    {
                        $id = $value['idBike'];
                        $photoToShow = $dao->GetPhotosLinkedToBike($id);

                        if(isset($photoToShow) && !empty($photoToShow))
                            echo "<div class='result-page'>
                                    <div class='search-page'>
                                        <div class='form-result'>
                                            <p>Marque: ".$value['bikBrand']."</p>
                                            <p>Couleur: ".$value['bikColor']."</p>
                                            <p>Serial: ".$value['bikSerialNumber']."</p>";

                                            if($value['bikHasBeenRetrieved'] == '0')
                                                echo "<p style='color: red;'>Le vélo n'a pas été rendu</p>";
                                            else
                                                echo "<p style='color: green;'>Le vélo a été récupéré</p>";
                                                
                                            echo "<img src='{$photosDir}".$photoToShow[0]['phoPath']."' class='img-result-page'>
                                            <a href = '../views/bikeDetails.php?id={$id}'>Details</a><br>
                                        </div>
                                    </div>
                                  </div>";
                    }
                ?>
            </div>
                    <div class="back-btn-div">
                        <a href="../views/searchPage.php">
                            <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
                        </a>
                    </div>
    </body>

</html>