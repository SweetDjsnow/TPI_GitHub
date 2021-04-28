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
    <script>
        function addBrand()
        {
            var brand = prompt("Entrez un nom de marque de vélo à ajouter.");
            if(brand != null)
            {
                window.location.href = "http://findbike21.section-inf.ch/my-app/controllers/addBrand.php?brand="+brand;
            }
        }
        function addColor()
        {
            var color = prompt("Entrez un nom de couleur à ajouter !");
            if(color != null)
            {
                window.location.href = "http://findbike21.section-inf.ch/my-app/controllers/addColor.php?color="+color;
            }
        }
    </script>
    <body>
        

        <div class="add-page">
            
            <h1 class="title-forms">Annoncer</h1>
            <?php if(isset($_SESSION['brandAdded']) && $_SESSION['brandAdded'] == 'true'){ echo "<p style='text-align: center; color: white; padding-top: 50px;'>Marque ajoutée à la base de données !</p>"; $_SESSION['brandAdded'] = 'false'; } ?>
            <?php if(isset($_SESSION['uploadSuccess']) && $_SESSION['uploadSuccess'] == 1){ echo"<p style='text-align: center; color: white; padding-top: 50px;'>Vélo ajouté à la base de données !</p>"; $_SESSION['uploadSuccess'] = 0;} ?>
            <?php if(isset($_SESSION['colorAdded']) && $_SESSION['colorAdded'] == 'true'){ echo "<p style='text-align: center; color: white; padding-top: 50px;'>Couleur ajoutée à la base de données !</p>"; $_SESSION['colorAdded'] = 'false'; } ?>
            <div class="form-add">
                <form class="login-form" action="../controllers/addBike.php" method="POST" enctype="multipart/form-data">

                    
                        <label for="image">Image (*.jpeg, *.jpg, *.png):</label>
                    <div class="input-wrapper">
                        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple required/>
                    </div>
                    
                        <label for="dateInput">Trouvé le :</label>
                    <div class="input-wrapper">
                        <input type="date" name="bikeFoundDate" id="dateInput" max="<?php echo date("Y-m-d"); ?>" required/>
                    </div>
                    
                        <label for="locationFound">Lieu de la trouvaille :</label>
                    <div class="input-wrapper">
                        <input type="text" name="bikFoundLocation" id="locationFound" required/>
                    </div>
                    
                    <label for="newBrand">Marque: </label>
                    
                        <table style="margin: auto;">
                            <tr>
                                <td>
                                    <div class="select-brand">
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
                                </td>
                                <td>
                                    <a onclick="addBrand()"><img src="../img/add-brand.png" class="add-brand-icon"></button>
                                </td>
                            </tr>

                        </table>
                    
                    
                    <label for="color">Couleur:</label>
                    <table style="margin: auto;">
                            <tr>
                                <td>
                                    <div class="select-brand">
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
                                </td>
                                <td>
                                    <a onclick="addColor()"><img src="../img/add-brand.png" class="add-brand-icon"></button>
                                </td>
                            </tr>
                    </table>

                    
                        <label for="serialNumber">Numero de série:</label>
                    <div class="input-wrapper">
                        <input type="text" name="bikSerialNumber" id="serialNumber" required>
                    </div>

                    
                        <label for="height">Taille du cadre:</label>
                    <div class="input-wrapper">
                        <input type="text" name="bikHeight" id="height" required>
                    </div>

                    
                        <label for="electric">Electrique ?</label>
                    <div class="input-wrapper">
                        <input type="checkbox" name="bikIsElectric">
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

    <?php
            include '../views/footer.html';
        ?>

</html>
<?php

?>