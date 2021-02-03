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
                    <input type="text" name="bikBrand" placeholder="Marque du vélo" value="*" />
                    <input type="text" name="bikColor" placeholder="Couleur" value="*" />
                    <input type="text" name="bikSerialNumber" placeholder="Numéro de série" value="*" />
                    <input type="text" name="bikHeight" placeholder="Taille du vélo (cm)" value="*" />
                    <label>Vélo electrique ?</label><input type="checkbox" name="bikIsElectric" placeholder="Vélo electrique ?" value="yes" checked/>
                    <button>Envoyer demande</button>
                </form>
        </div>

    </body>

</html>