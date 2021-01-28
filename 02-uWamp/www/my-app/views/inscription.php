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

        <?php
            $mbox = imap_open("{outlook.office365.com:993/imap/ssl}", "michel.dossantos@eduvaud.ch", "1qay2wsxRex998...!?");

            echo "<h1>Mailboxes</h1>\n";
            $folders = imap_listmailbox($mbox, "{outlook.office365.com:993/imap/ssl}", "*");
            
            if ($folders == false) {
                echo "Appel échoué<br />\n";
            } else {
                foreach ($folders as $val) {
                    echo $val . "<br />\n";
                }
            }
            
            echo "<h1>en-têtes dans INBOX</h1>\n";
            $headers = imap_headers($mbox);
            
            if ($headers == false) {
                echo "Appel échoué<br />\n";
            } else {
                foreach ($headers as $val) {
                    echo $val . "<br />\n";
                }
            }
            
            imap_close($mbox);
            echo phpinfo();
        ?>

    </body>

</html>