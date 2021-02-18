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
                <div>
                    
                    <form action="../views/searchPage.php" method="POST">
                        <label>Receveur:</label>
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

                        <div class="retrieve-link">
                            <a href="#" style="width: 100%;">Créer receveur</a>
                        </div>


                        <label>Donneur:</label>
                        
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

                        <div class="retrieve-link">
                            <a href="#">Créer donneur</a>
                        </div>

                        <button>Rendre</button>

                    </form>
                </div>
                
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
