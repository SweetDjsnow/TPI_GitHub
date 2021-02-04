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
                    <input type="text" name="bikBrand" placeholder="Marque du vélo" />
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
    </body>

</html>