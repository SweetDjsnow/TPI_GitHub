<?php
include '../controllers/checkIfConnectedAdmin.php';
include '../models/dao.php';
include '../views/navBar.php';

$dao = new Database();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Annoncer</title>
    </head>
    <body>
        

        <div class="signup-page">
            
            <h1 class="title-forms">Annoncer</h1>
            <?php if(isset($_SESSION['uploadSuccess']) && $_SESSION['uploadSuccess'] == 1){ echo"<p style='text-align: center; color: white; padding-top: 50px;'>Vélo ajouté à la base de données !</p>"; $_SESSION['uploadSuccess'] = 0;} ?>
            <div class="form">
                <form class="login-form" action="../controllers/addBike.php" method="POST" enctype="multipart/form-data">
                    <label for="image">Image:</label>
                    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple required/>
                    <label for="dateInput">Trouvé le :</label>
                    <input type="date" name="bikeFoundDate" id="dateInput" required/>
                    <label for="locationFound">Lieu de la trouvaille :</label>
                    <input type="text" name="bikFoundLocation" id="locationFound" required/>
                    
                    <label for="slct">Marque:</label>
                    <div class="select">
                        <select name="bikBrand" id="slct" required>
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
                    <div class="select">
                        <select name="color" id="slct" required>
                            <?php
                                $colors = $dao->GetAllColorNames();
                                foreach($colors as $key => $value)
                                {
                                    echo '<option value = "'.$value['colName'].'">'.$value['colName'].'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <label for="serialNumber">Numero de série:</label>
                    <input type="text" name="bikSerialNumber" id="serialNumber" required>

                    <label for="height">Taille du cadre:</label>
                    <input type="text" name="bikHeight" id="height" required>

                    <label for="electric">Electrique ?</label>
                    <input type="checkbox" name="bikIsElectric">

                    <label for="slct">Retrouvé par la commune:</label>
                    
                    <input type="text" name="city" value="<?php echo $_SESSION['useCity']; ?>" readonly>

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

    <?php
            include '../views/footer.html';
        ?>

</html>
<?php

?>