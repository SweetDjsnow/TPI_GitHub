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

$idCity = $bikeInfos[0]['idCity'];
$cityName = $dao->GetCityName($idCity);
$photos = $dao->GetPhotosLinkedToBike($bikeInfos[0]['idBike']);
$photosDir = '../img/bike_photos/';


?>
<!DOCTYPE html>

<script>
var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
</script>

<html>
    <head>
        <link rel="stylesheet" href="../css/styles.css">
        <title>Détails</title>
    </head>
    <body>
    <?php
    ?>
        <h1>Détails</h1>
        <div class="main-page-form">
            <div class="form-details">
                <h1>Stocké à la commune de <?php echo $cityName[0]['citName']; ?></h1>
                <!-- Slideshow container -->
                <div class="slideshow-container">
                    <!-- Full-width images with number and caption text -->
                    <?php
                    $numberOfPhotos = count($photos);
                    for($i = 0; $i< $numberOfPhotos; $i++)
                    {
                        if($i==0)
                        {
                            echo "  <div class='mySlides fade' style='display: block;'>
                                        <div class='numbertext'>1 / {$numberOfPhotos}</div>
                                        <img src='{$photosDir}".$photos[$i]['phoPath']."' style='width:50%; max-height: 300px;'>
                                    </div>";
                        }
                        else
                        {
                            echo "  <div class='mySlides fade' style='display: none;'>
                                        <div class='numbertext'>1 / {$numberOfPhotos}</div>
                                        <img src='{$photosDir}".$photos[$i]['phoPath']."' style='width:50%; max-height: 300px;'>
                                    </div>";
                        }
                    }
                    ?>

                    <!-- Next and previous buttons -->
                    <?php 
                        if($numberOfPhotos > 1)
                        {
                            echo '<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                            <a class="next" onclick="plusSlides(1)">&#10095;</a>';
                        } 
                    ?>
                    
                    
                </div>
                <br>

                <!-- The dots/circles -->
                <div style="text-align:center">
                    <?php 
                    for($i=1;$i<=$numberOfPhotos;$i++)
                    {
                        echo "<span class='dot' onclick='currentSlide({$i})'></span>";
                    }
                    ?>
                </div>

                <?php

                ?>

                <table class="table-details" style="float: left;">
                    <tr>
                        <th>Trouvé le: </th>
                        <td><?php echo $bikeInfos[0]['bikeFoundDate'];?></td>
                    </tr>
                    <tr>
                        <th>Trouvé à: </th>
                        <td><?php echo $bikeInfos[0]['bikFoundLocation'];?></td>
                    </tr>
                    <tr>
                        <th>Marque: </th>
                        <td><?php echo $bikeInfos[0]['bikBrand'];?></td>
                    </tr>
                    <tr>
                        <th>Couleur: </th>
                        <td><?php echo $bikeInfos[0]['bikColor'];?></td>
                    </tr>
                    <tr>
                        <th>Numéro de série: </th>
                        <td><?php echo $bikeInfos[0]['bikSerialNumber'];?></td>
                    </tr>
                    
                </table>
                <table class="table-details" style="float: right;">
                    <tr>
                        <th>Taille du cadre: </th>
                        <td><?php echo $bikeInfos[0]['bikHeight'];?></td>
                    </tr>
                    <tr>
                        <th>Electrique: </th>
                        <td><?php echo $bikeInfos[0]['bikIsElectric'];?></td>
                    </tr>
                    <tr>
                        <th>Rendu le: </th>
                        <td><?php echo $bikeInfos[0]['bikRetrieveDate'];?></td>
                    </tr>
                    <tr>
                        <th>Recupéré par: </th>
                        <td>
                            <?php if(!empty($bikeInfos[0]['idReceiver'])){$receiverInfos = $dao->GetReceiverInfos($bikeInfos[0]['idReceiver']);echo $receiverInfos[0]['recFirstName'].' '.$receiverInfos[0]['recLastName'];}?>
                        </td>
                    </tr>
                    <tr>
                        <th>Donné par: </th>
                        <td>
                            <?php if(!empty($bikeInfos[0]['idGiver'])){$giverInfos = $dao->GetGiverInfos($bikeInfos[0]['idGiver']);echo $giverInfos[0]['givFirstName'].' '.$giverInfos[0]['givLastName'];}?>
                        </td>
                    </tr>
                </table>

                <div class="back-btn-div">

        <?php 
            if($bikeInfos[0]['bikHasBeenRetrieved'] == 0)
            {
                echo    '<a href="../views/retrievePage.php?id='.$bikeInfos[0]['idBike'].'"> 
                            <button class="retrieve-btn">Rendre</button>
                        </a>';
            }
        ?>
        </div>
            </div>
            
        </div>

        <div class="back-btn-div">
        <a href="../controllers/searchDatabase.php">
            <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
        </a>
        </div>

    </body>

    <?php
            include '../views/footer.html';
        ?>

</html>