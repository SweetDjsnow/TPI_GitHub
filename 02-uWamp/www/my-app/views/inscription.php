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
                <form class="login-form" action="../controllers/sendMailRequest.php" method="POST">
                    <p>Si la commune est déjà inscrite au site, cliquez <a href="./inscriptionUser.php">ici</a></p>
                    <input type="text" name="cityName" placeholder="Nom de la commune" required/>
                    <input type="text" name="firstName" placeholder="Prénom" required/>
                    <input type="text" name="lastName" placeholder="Nom" required/>
                    <input type="text" name="email" placeholder="Adresse email de contact" required/>
                    <input type="text" name="phoneNumber" placeholder="Numéro de téléphone" required/>
                    <input type="text" name="officeAddress" placeholder="Addresse du bureau" required/>
                    <input type="text" name="npa" placeholder="Code postal" required/>
                    <button type="submit" name="submitBtn" value="submit">Envoyer</button>
                </form>
        </div>

        <div class="back-btn-div">
        <a href="../views/index.php">
            <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
            </
        </div>

    </body>

</html>