<?php

    include '../controllers/checkIfConnected.php';
    include '../models/dao.php';
    
    $dao = new Database();
    $idBike = $_GET['id'];

    $bikeInfos = $dao->GetBikeInfos($idBike);

            
    if(empty($bikeInfos)) 
    {
        header("location: ./mainPage.php");
    }

    include '../views/navBar.php';


?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Rendre le vélo</title>
    </head>
    <body>
        <h1 class="retrieve-page-title">Définir le receveur et donneur du vélo</h1>
        <div class="retrieve-page-form">
            <div class="form-retrieve">
                <table style="width: 100%" class="table-retrieve-page">
                    <tr>
                        <th>Receveur</th>
                        <th>Donneur</th>
                    </tr>
                    <?php echo '<form action="../controllers/setReceiverAndGiverOfBike.php?id='.$_GET['id'].'" method="POST">'; ?>
                        <tr>
                            <td>
                                <input type="text" placeholder="Prénom" name="firstName" required>
                                <input type="text" placeholder="Nom de famille" name="lastName" required>
                                <input type="text" placeholder="Adresse email" name="email">
                                <input type="text" placeholder="Numéro de téléphone" name="phoneNumber" required>
                                <input type="text" placeholder="Preuve d'achat" name="buyProof" required>
                                <input type="text" placeholder="Preuve d'identité du receveur" name="idProof" required>
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
                            <?php
                                if($bikeInfos[0]['idCity'] == $_SESSION['idCity'])
                                    echo '<button style="width: 60%;margin-bottom: 20px; margin-top: 10px; margin-left: 20%;">Rendre</button>';
                                else
                                    echo '<button style="width: 60%;margin-bottom: 20px; margin-top: 10px; margin-left: 20%; background-color: gray;" disabled>Vous ne pouvez pas rendre ce vélo</button>';
                            ?>
                            </td>
                        </tr>
                    </form>
                    <tr>
                        <td colspan="2" style="padding-bottom: 30px;"></td>
                    </tr>
                    
                </table>
                
                
            </div>
            
            


            <div class="back-btn-div">
                <a href="../views/bikeDetails.php?id=<?php echo $idBike; ?>">
                    <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
                </a>
            </div>

        </div>
        

    </body>

    <?php
            include '../views/footer.html';
        ?>

</html>

<?php

?>
