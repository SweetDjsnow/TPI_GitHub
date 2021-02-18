<?php

    include '../controllers/checkIfConnected.php';
    include '../models/dao.php';

    $dao = new Database();

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Page Title</title>
    </head>
    <body>
        <h1 class="retrieve-page-title">Définir le receveur et donneur du vélo</h1>
        <div class="retrieve-page-form">
            <div class="form">
                <table style="width: 100%">
                    <tr>
                        <th>Receveur</th>
                        <th>Donneur</th>
                    </tr>
                    <form action="#" method="POST">
                        <tr>
                            <td>
                                <div class="select">
                                    <select name="retriever" id="slct">
                                        <?php
                                            $retrievers = $dao->GetAllReceiver();
                                            foreach($retrievers as $key => $value)
                                            {
                                                echo '<option value = "'.$value['idReceiver'].'">'.$value['recFirstName']." ".$value['recLastName'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="select">
                                    <select name="giver" id="slct">
                                        <?php
                                            $givers = $dao->GetAllGiver();
                                            foreach($givers as $key => $value)
                                            {
                                                echo '<option value = "'.$value['idGiver'].'">'.$value['givFirstName']." ".$value['givLastName'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <button style="width: 60%;margin-bottom: 20px; margin-top: 10px;">Rendre</button>
                            </td>
                        </tr>
                    </form>
                    <tr>
                        <td colspan="2" style="padding-bottom: 30px;"></td>
                    </tr>
                    <tr>
                        <td>
                            Ajouter un receveur
                        </td>
                        <td>
                            Ajouter un donneur
                        </td>
                    </tr>
                    <tr>
                        <td style="border-right: solid gray 2px;">
                            <form action="../views/searchPage.php" method="POST" class="create-form">
                                <input type="text" placeholder="Prénom" name="firstName">
                                <input type="text" placeholder="Nom de famille" name="lastName">
                                <input type="text" placeholder="Adresse email" name="email">
                                <input type="text" placeholder="Numéro de téléphone" name="phoneNumber">
                                <button style="width: 60%;">Ajouter</button>
                            </form>
                        </td>
                        <td>
                            <form action="../views/searchPage.php" method="POST" class="create-form">
                                <input type="text" placeholder="Prénom" name="firstName">
                                <input type="text" placeholder="Nom de famille" name="lastName">
                                <input type="text" placeholder="Adresse email" name="email">
                                <input type="text" placeholder="Numéro de téléphone" name="phoneNumber">
                                <button style="width: 60%;">Ajouter</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                    
                    </tr>
                </table>
                
                
            </div>
            
            


            <div class="back-btn-div">
                <a href="../views/mainPage.php">
                    <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
                </a>
            </div>

        </div>
        

    </body>

</html>

<?php

?>
