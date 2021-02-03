<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Inscription</title>
    </head>
    <body>
        <h1>INSCRIPTION</h1>

        <div class="login-page">

            <div class="form">
                <form class="login-form" action="../controllers/sendMailRequest.php" method="POST">
                    <input type="text" name="cityName" placeholder="Nom de la commune" required/>
                    <input type="text" name="firstName" placeholder="Prénom" required/>
                    <input type="text" name="lastName" placeholder="Nom" required/>
                    <input type="text" name="email" placeholder="Adresse email de contact" required/>
                    <input type="text" name="phoneNumber" placeholder="Numéro de téléphone" required/>
                    <input type="text" name="officeAddress" placeholder="Addresse du bureau" required/>
                    <input type="text" name="npa" placeholder="Code postal" required/>
                    <button>Envoyer demande</button>
                </form>
        </div>

    </body>

</html>