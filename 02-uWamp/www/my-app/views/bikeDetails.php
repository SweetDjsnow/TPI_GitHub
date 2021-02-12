<?php
include '../controllers/checkIfConnected.php';
include '../models/dao.php';

$idBike = $_GET['id'];

$dao = new Database();
$bikeInfos = $dao->GetBikeInfos($idBike);
$idCity = $bikeInfos[0]['idCity'];
$cityName = $dao->GetCityName($idCity);
var_dump($bikeInfos);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Page Title</title>
    </head>
    <body>
        <h1>Détails</h1>
        <div class="main-page-form">
            <div class="form">
                <h1>Stocké à la commune de <?php echo $cityName[0]['citName']; ?></h1>
                <table class="table-details" style="float: left;">
                    <tr>
                        <th>Trouvé le: </th>
                        <td><?php ?></td>
                    </tr>
                    <tr>
                        <th>Lieu de trouvaille: </th>
                        <td>Jackson</td>
                    </tr>
                    <tr>
                        <th>Marque: </th>
                        <td>Test</td>
                    </tr>
                    <tr>
                        <th>Couleur: </th>
                        <td>Test</td>
                    </tr>
                    <tr>
                        <th>Numéro de série: </th>
                        <td>Test</td>
                    </tr>
                    
                </table>
                <table class="table-details" style="float: right;">
                    <tr>
                        <th>Taille du cadre: </th>
                        <td>Test</td>
                    </tr>
                    <tr>
                        <th>Est electrique ?: </th>
                        <td>Smith</td>
                    </tr>
                    <tr>
                        <th>Recupéré par:  </th>
                        <td>Jackson</td>
                    </tr>
                    <tr>
                        <th>Donné par:  </th>
                        <td>Test</td>
                    </tr>
                    <tr>
                        <th>Stocké par la commune: </th>
                        <td>Test</td>
                    </tr>

                </table>
            </div>
        </div>
    </body>

</html>