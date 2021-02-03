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
        <h1>INSCRIPTION</h1>

        <div class="signup-page">

            <div class="form">
                <form class="login-form" action="../controllers/sendMailRequestUser.php" method="POST">
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
                    <input type="text" name="firstName" placeholder="Prénom" required/>
                    <input type="text" name="lastName" placeholder="Nom" required/>
                    <input type="text" name="email" placeholder="Adresse email de contact" required/>
                    <input type="text" name="phoneNumber" placeholder="Numéro de téléphone" required/>
                    <input type="text" name="officeAddress" placeholder="Addresse du bureau" required/>
                    <input type="text" name="npa" placeholder="Code postal" required/>
                    <button>Envoyer demande</button>
                </form>
        </div>

        <div class="back-btn-div">
        <a href="../views/inscription.php">
            <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
            </
        </div>

        

    </body>

</html>