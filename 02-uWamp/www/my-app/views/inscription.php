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
            $mbox = imap_open("{outlook.office365.com:993/imap/ssl}", "found.your.bike@outlook.fr", "Pass4ETML_tpi_2021");

            $emails = imap_search($mbox, 'From "found.your.bike@outlook.fr"');

            $num = imap_num_msg($mbox);

            $result = imap_body($mbox,$num);

            $splits = explode("\r\n",$result);


            $array = count($splits);

            for($i = 0; $i < $array; $i++)
            {
                if($i % 2 != 0)
                    echo "[{$i}]".$splits[$i]."\r\n";
                
            }

            
            echo phpinfo();
        ?>

    </body>

</html>