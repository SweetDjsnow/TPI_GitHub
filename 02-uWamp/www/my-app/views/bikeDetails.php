<?php
include '../controllers/checkIfConnected.php';
include '../models/dao.php';

$idBike = $_GET['id'];

$dao = new Database();
$bikeInfos = $dao->GetBikeInfos($idBike);
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
        <title>Page Title</title>
    </head>
    <body>
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
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
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
                        <th>Recupéré par:  </th>
                        <td><?php
                            
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Donné par:  </th>
                        <td>
                        <?php
                            
                        ?>
                        </td>
                    </tr>

                </table>

                
            </div>
            
        </div>

        <div class="back-btn-div">
        <a href="../views/mainPage.php">
            <button class="back-btn"><img src="../img/left-arrow.png" alt="Back Arrow"></button>
        </a>
        </div>

    </body>

</html>