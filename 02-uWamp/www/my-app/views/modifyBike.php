<?php

include '../models/dao.php';

$dao = new Database();
$idBike = $_GET['id'];
$bikeInfos = $dao->GetBikeInfos($idBike);
var_dump($bikeInfos);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/select.css">
        <title>Page Title</title>
    </head>
    <body>

        <div class="main-page-form">
            <h1 style="text-align: center;">Modifier le vélo</h1>
            <div class="form-details">
                <form action="../controllers/modifyBikeData.php" method="$_POST">
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
                                <select name="bikBrand" id="slct">
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
                                <select name="color" id="slct">
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
                                <select name="bikIsElectric" id="slct">
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

                </table>
                </form>
            </div>
        </div>
        

    </body>

</html>