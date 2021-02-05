<?php
include '../controllers/checkIfConnected.php';
include '../models/dao.php';

$dao = new Database();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Recherche</title>
    </head>
    <body>
        <h1>Recherche</h1>

        <div class="login-page">

            <div class="form">
                <form class="login-form" action="../controllers/searchDatabase.php" method="POST">
                <label for="slct">Marque:</label>
                    <div class="select">
                        <select name="bikBrand" id="slct">
                            <option disabled selected value> -- select an option -- </option>
                            <?php
                                $brands = $dao->GetAllBrands();
                                foreach($brands as $key => $value)
                                {
                                    echo '<option value = "'.$value['braName'].'">'.$value['braName'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <input type="text" name="bikColor" placeholder="Couleur" />
                    <input type="text" name="bikSerialNumber" placeholder="Numéro de série" />
                    <input type="text" name="bikHeight" placeholder="Taille du vélo (cm)" />
                    <label>Vélo electrique ?</label><input type="checkbox" name="bikIsElectric" placeholder="Vélo electrique ?"/>
                    <button>Envoyer demande</button>
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