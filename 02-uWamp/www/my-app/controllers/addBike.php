<?php

if(isset($_POST))
{
    include '../models/dao.php';
    $dao = new Database();

    $numberOfFiles = count($_FILES['fileToUpload']['name']);
    $numberFilesUploaded = 0;
    $target_dir = "../img/bike_photos/";

    for($i = 0; $i<count($_FILES['fileToUpload']['name']); $i++)
    {

        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not a video";
                $uploadOk = 0;
            }
        }

        echo "<br><br><br>";

        // Check if file already exists
        if (file_exists($target_file)) {

            echo "File already exists. Generating new name...";
            do
            {
                $newName = RandomName(10);
                $target_file = $target_dir.$newName.'.'.$imageFileType;
            }while(file_exists($target_file));
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"][$i] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg") {
            echo "Sorry, only PNG & JPG files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) 
            {
                $numberFilesUploaded++;
                echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
            } else {
                echo "Error : The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " couldn't be uploaded";
            }
        }
    }

    if($numberFilesUploaded < count($_FILES['fileToUpload']['name']))
    {
        echo "Erreur lors de l'upload d'une ou plusieurs des photos. Action annulée.";
    }
    else
    {
        $bikeFoundDate = $_POST['bikeFoundDate'];
        $bikFoundLocation = $_POST['bikFoundLocation'];
        $bikBrand = $_POST['bikBrand'];
        $bikColor = $_POST['bikColor'];
        $bikSerialNumber = $_POST['bikSerialNumber'];
        $bikHeight = $_POST['bikHeight'];

        $bikIsElectric = 0;
        if(isset($_POST['bikIsElectric']))
        {
            $bikIsElectric = 1;
        }
        else
        {
            $bikIsElectric = 0;
        }

        echo $bikIsElectric."<br><br><br>";

        $cityName = $_POST['city'];

        $cityId = $dao->GetCityId($cityName);

        $lastId = $dao->AddBikeToDatabase($bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $cityId[0]['idCity']);

        for($i = 0; $i<count($_FILES['fileToUpload']['name']); $i++)
        {

            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);

            $dao->AddPhotoToDatabase($target_file, $lastId[0]['MAX(idBike)']);
        }
        
    }
}



function RandomName($length) {
    $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

?>