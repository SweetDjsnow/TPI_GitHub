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
                    <input type="text" name="cityName" placeholder="Nom de la commune"/>
                    <input type="text" name="firstName" placeholder="Prénom"/>
                    <input type="text" name="lastName" placeholder="Nom"/>
                    <input type="text" name="email" placeholder="Adresse email de contact"/>
                    <input type="text" name="phoneNumber" placeholder="Numéro de téléphone"/>
                    <input type="text" name="officeAddress" placeholder="Addresse du bureau"/>
                    <input type="text" name="npa" placeholder="Code postal"/>
                    <button>Envoyer demande</button>
                </form>
        </div>


    </body>

</html>