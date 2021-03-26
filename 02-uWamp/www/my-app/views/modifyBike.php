<?php

include '../controllers/checkIfConnectedAdmin.php';
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
        <title>Modifier</title>
    </head>
    <body>

        <div class="main-page-form">
            <h1 style="text-align: center;">Modifier le vélo</h1>
            <?php if(isset($_SESSION['bikeUpdated']) && $_SESSION['bikeUpdated'] == 'true'){ echo "<h3 style='color: white;'>Le vélo a été modifié !</h3>"; } ?>
            <div class="form-modify">
                <form action="../controllers/modifyBikeData.php?id=<?php echo $idBike; ?>" method="POST">
                <table class="table-details" style="float: left;">
                    <tr>
                        <th>Trouvé le: </th>
                        <td><input type="date" name="bikFoundDate" value="<?php echo $bikeInfos[0]['bikeFoundDate'] ?>"></td>
                    </tr>
                    <tr>
                        <th>Trouvé à: </th>
                        <td><input type="text" name="bikFoundLocation" value="<?php echo $bikeInfos[0]['bikFoundLocation']?>"></td>
                    </tr>
                    <tr>
                        <th>Marque: </th>
                        <td>
                            <div class="select">
                                <select name="bikBrand" id="slct" class="select-modify">
                                    <?php
                                        $brands = $dao->GetAllBrands();
                                        foreach($brands as $key => $value)
                                        {
                                            if($value['braName'] != $bikeInfos[0]['bikBrand'])
                                                echo '<option value = "'.$value['braName'].'">'.$value['braName'].'</option>';
                                            else
                                                echo '<option value = "'.$value['braName'].'" selected="selected">'.$value['braName'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Couleur: </th>
                        <td>
                            <div class="select">
                                <select name="color" id="slct"  class="select-modify">
                                    <?php
                                        $colors = $dao->GetAllColorNames();
                                        foreach($colors as $key => $value)
                                        {
                                            if($value['colName'] != $bikeInfos[0]['bikColor'])
                                                echo '<option value = "'.$value['colName'].'">'.$value['colName'].'</option>';
                                            else
                                                echo '<option value = "'.$value['colName'].'" selected="selected">'.$value['colName'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Numéro de série: </th>
                        <td><input type="text" name="bikSerialNumber" value="<?php echo $bikeInfos[0]['bikSerialNumber']?>"></td>
                    </tr>
                    
                </table>
                <table class="table-details" style="float: right;">
                    <tr>
                        <th>Taille du cadre: </th>
                        <td><input type="text" name="bikHeight" value="<?php echo $bikeInfos[0]['bikHeight']?>"></td>
                    </tr>
                    <tr>
                        <th>Electrique: </th>
                        <td>
                            <div class="select">
                                <select name="bikIsElectric" id="slct"  class="select-modify">
                                    <option value="0" 
                                    <?php if($bikeInfos[0]['bikIsElectric'] == '0')
                                            echo 'selected="selected"';
                                     ?>>Non</option>

                                    <option value="1" <?php if($bikeInfos[0]['bikIsElectric'] == '1')
                                            echo 'selected="selected"';
                                     ?>
                                     >Oui</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>A été rendu: </th>
                        <td>
                            <input type="text" name="bikHasBeenRetrieved" value="<?php if($bikeInfos[0]['bikHasBeenRetrieved'] == '0'){echo "Non";}else{echo "Oui";}?>" disabled="disabled">
                        </td>
                    </tr>
                    <tr>
                        <th>Rendu le: </th>
                        <td><input type="date" name="bikRetrieveDate" value="<?php echo $bikeInfos[0]['bikRetrieveDate']; ?>" <?php if($bikeInfos[0]['bikRetrieveDate'] == null){echo "disabled = 'disabled'";} ?>></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-bottom: 2px solid gray;"></td>
                    </tr>
                    <tr style="border-top: 2px solid gray;">
                        <th>Recupéré par:  </th>
                        <td>
                        <?php
                            if(!empty($bikeInfos[0]['idReceiver']))
                            {
                                $receiverInfos = $dao->GetReceiverInfos($bikeInfos[0]['idReceiver']);
                                echo $receiverInfos[0]['recFirstName'].' '.$receiverInfos[0]['recLastName'];
                            }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Donné par:  </th>
                        <td>
                        <?php
                            if(!empty($bikeInfos[0]['idGiver']))
                            {
                                $giverInfos = $dao->GetGiverInfos($bikeInfos[0]['idGiver']);
                                echo $giverInfos[0]['givFirstName'].' '.$giverInfos[0]['givLastName'];
                            }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php if($bikeInfos[0]['bikHasBeenRetrieved'] == '1'){ echo '<a href="../controllers/resetGiverReceiver.php?id='.$idBike.'">Reset donneur/receveur</a>';} ?>
                        </td>
                    </tr>

                </table>
                
                <button>Modifier</button>

                </form>
                

            </div>

            <div class="back-btn-div">
                    <a href='../controllers/searchDatabase.php'>
                        <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
                    </a>
            </div>

        </div>
        

    </body>

    <?php
            include '../views/footer.html';

            if(isset($_SESSION['bikeUpdated']) && $_SESSION['bikeUpdated'] == 'true')
                $_SESSION['bikeUpdated'] = 'false';
        ?>

</html>