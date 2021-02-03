<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/select.css">
        <title>Page Title</title>
    </head>
    <body>

        <div class="login-page">
            <div class="form">
                <form class="login-form" action="../controllers/login.php" method="post">
                    <input type="username" placeholder="Nom d'utilisateur" name="username"/>
                    <input type="password" placeholder="Mot de passe" name="password"/>
                    <button type="submit" name="submitBtn" value="submit">Se connecter</button>
                    <p class="message">Vous n'avez pas de compte ? <a href="./inscription.php">Faites une demande !</a></p>
                </form>
            </div>
        </div>
        

    </body>

</html>
