<?php
include '../models/dao.php';

$dao = new Database();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Inscription</title>
    </head>
    <body>
        <h1>ANNONCER</h1>

        <div class="signup-page">

            <div class="form">
                <form class="login-form" action="../controllers/addBike.php" method="POST" enctype="multipart/form-data">
                    <label for="image">Image:</label>
                    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple/>
                    <label for="dateInput">Trouvé le :</label>
                    <input type="date" name="bikeFoundDate" id="dateInput" />
                    <label for="locationFound">Lieu de la trouvaille :</label>
                    <input type="text" name="bikFoundLocation" id="locationFound" />
                    
                    <label for="slct">Marque:</label>
                    <div class="select">
                        <select name="brand" id="slct">
                            <?php
                                $brands = $dao->GetAllBrands();
                                foreach($brands as $key => $value)
                                {
                                    echo '<option value = "'.$value['braName'].'">'.$value['braName'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    
                    <label for="color">Couleur:</label>
                    <input type="text" name="bikColor" id="color">

                    <label for="serialNumber">Numero de série:</label>
                    <input type="text" name="bikSerialNumber" id="serialNumber">

                    <label for="height">Taille du cadre:</label>
                    <input type="text" name="bikHeight" id="height">

                    <label for="electric">Electrique ?</label>
                    <input type="checkbox" name="bikIsElectric">

                    <label for="slct">Retrouvé par la commune:</label>
                    <div class="select">
                        <select name="city" id="slct">
                            <?php
                                $cities = $dao->GetAllCities();
                                foreach($cities as $key => $value)
                                {
                                    echo '<option value = "'.$value['citName'].'">'.$value['citName'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="submitBtn" value="submit">Annoncer</button>
                </form>
            </div>
                
            <div class="back-btn-div">
        <a href="../views/mainPage.php">
            <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
        </a>
        </div>
        </div>

        

    </body>

</html>
<?php

?>