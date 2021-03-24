<?php
include '../controllers/checkIfConnected.php';
include '../models/dao.php';
include '../views/navBar.php';

$dao = new Database();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Recherche</title>
    </head>
    <body>

        <div class="login-page">
            <h1 class="title-forms">Rechercher</h1>
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
                    <label for="bikColor">Couleur:</label>
                    <div class="select">
                        <select name="bikColor" id="slct">
                        <option disabled selected value> -- select an option -- </option>
                            <?php
                                $colors = $dao->GetAllColorNames();
                                foreach($colors as $key => $value)
                                {
                                    echo '<option value = "'.$value['colName'].'">'.$value['colName'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
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

    <?php
            include '../views/footer.html';
        ?>

</html>