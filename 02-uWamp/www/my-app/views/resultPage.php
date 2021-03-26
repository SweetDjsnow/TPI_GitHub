<?php

include '../controllers/checkIfConnected.php';
include '../views/navBar.php';
$photosDir = '../img/bike_photos/';

?>

<script>

function deleteConfirmation(id)
{
    if(!confirm('Voulez-vous vraiment supprimer ce vélo ?')) 
        return false;
    else
        window.location.href = "http://findbike21.section-inf.ch/my-app/controllers/deleteBike.php?id="+id;
}

</script>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Résultats</title>
    </head>
    <body>
        <h1 class="title-forms-result"><?php echo $numberOfResults[0]['COUNT(*)']; ?> Résultats</h1>
            <div class="all-result-div">
                <?php
                    $i = 0;
                    if(isset($result))
                    {
                        foreach($result as $key => $value)
                        {
                            $id = $value['idBike'];
                            $photoToShow = $dao->GetPhotosLinkedToBike($id);

                            if(isset($photoToShow) && !empty($photoToShow))
                            {
                                echo "<div class='result-page'>
                                        <div class='search-page'>
                                            <div class='form-result' ";
                                            if($i == $numberOfResults[0]['COUNT(*)'] - 1)
                                            {
                                                echo "style = 'margin-bottom: 30px;'";
                                            }
                                            echo ">";
                                            if(isset($_SESSION) && $_SESSION['useIsAdmin'] == 1)
                                                echo "<a class='delete-button' onclick='deleteConfirmation({$id})'><img src='../img/close.png'></a>";
                                                echo "<p>Marque: ".$value['bikBrand']."</p>
                                                <p>Couleur: ".$value['bikColor']."</p>
                                                <p>Serial: ".$value['bikSerialNumber']."</p>";

                                                if($value['bikHasBeenRetrieved'] == '0')
                                                    echo "<p style='color: red; font-weight: bold;'>Le vélo n'a pas été rendu</p>";
                                                else
                                                    echo "<p style='color: green; font-weight: bold;'>Le vélo a été récupéré</p>";
                                                    
                                                echo "<img src='{$photosDir}".$photoToShow[0]['phoPath']."' class='img-result-page'>
                                                <table class='table-results'>
                                                    <tr>
                                                        <td style='float: left;'>
                                                            <a href = '../views/bikeDetails.php?id={$id}'>Details</a><br>
                                                        </td>";
                                                        if($_SESSION['useIsAdmin'] == '1')
                                                            echo "<td style='float: right;'>
                                                                <a href = '../views/modifyBike.php?id={$id}'>Modifier</a><br>
                                                            </td>";
                                                    echo "</tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>";
                            }
                            $i++;
                        }
                    }
                    if($i==0)
                    {
                        echo "<h1>Aucuns résultats trouvés...</h1>";
                    }

                   
                ?>
            </div>
            <div class="page-number-container">
                    <p>Page : 
                    <?php 
                        if(isset($_GET['page']))
                        {
                            echo $_GET['page'];
                        }
                        else
                        {
                            echo "1";
                        }
                    ?></p>
            </div>
            <div class="change-page-container">
            <?php
                    $tp = $numberOfResults[0]['COUNT(*)'] / $resultsPerPage;
                    $previous = $pc -1;
                    $next = $pc +1;
                    if ($pc>1) 
                    {
                        echo " <a href='?page=$previous'>&#8592;</a> ";
                    }
                    echo "|";
                    if ($pc<$tp)
                    {
                        echo " <a href='?page=$next'>&#8594;</a>";
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