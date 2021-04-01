<?php

if(session_status()== PHP_SESSION_NONE)
{
    session_start();
}



if(isset($_POST) && !empty($_POST))
{
    if(isset($_SESSION) && $_SESSION['useIsAdmin'] == 1)
    {
        if(isset($_POST['submitBtn']))
        {
            if(!empty($_FILES))
            {
                if(isset($_POST['bikeFoundDate']) && isset($_POST['bikFoundLocation']) && isset($_POST['bikBrand']) && isset($_POST['color']) && isset($_POST['bikSerialNumber']) && isset($_POST['bikHeight']) && isset($_SESSION['idCity']))
                {
                    if($_POST['bikeFoundDate'] != '' && $_POST['bikFoundLocation'] != '' && $_POST['bikBrand'] != '' && $_POST['color'] != '' && $_POST['bikSerialNumber'] != '' && $_POST['bikHeight'] != '')
                    {
                        include '../models/dao.php';
                        $dao = new Database();

                        $numberOfFiles = count($_FILES['fileToUpload']['name']);
                        $numberFilesUploaded = 0;
                        $target_dir = "../img/bike_photos/";

                        $newName = array();


                        for($i = 0; $i<count($_FILES['fileToUpload']['name']); $i++)
                        {

                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
                            $uploadOk = 1;
                            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                            // Check if image file is a actual image or fake image
                            if(isset($_POST["submit"])) {
                                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);
                                if($check !== false) {
                                    //echo "File is an image - " . $check["mime"] . ".";
                                    $uploadOk = 1;
                                } else {
                                    echo "File is not a video";
                                    $uploadOk = 0;
                                }
                            }

                            ///////GENERATING NEW NAME FOR IMG
                            do
                            {
                                $newNameString = RandomName(10);
                                $target_file = $target_dir.$newNameString.'.'.$imageFileType;
                            }while(file_exists($target_file));

                            array_push($newName,$newNameString.'.'.$imageFileType);

                            //var_dump($newName);
                            //var_dump($target_file);

                            // Check file size
                            if ($_FILES["fileToUpload"]["size"][$i] > 5000000) {
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
                                    //echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";
                                } else {
                                    echo "Error : The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " couldn't be uploaded";
                                }
                            }
                        }
                    

                        if($numberFilesUploaded < count($_FILES['fileToUpload']['name']))
                        {
                            //var_dump($_FILES['fileToUpload']['name'][0]);
                            echo "Erreur lors de l'upload d'une ou plusieurs des photos. Action annulée.";
                        }
                        else
                        {
                            ///////////Variables du vélo à ajouter/////////
                            $bikeFoundDate = $_POST['bikeFoundDate'];
                            $bikFoundLocation = $_POST['bikFoundLocation'];
                            $bikBrand = $_POST['bikBrand'];
                            $bikColor = $_POST['color'];
                            $bikSerialNumber = $_POST['bikSerialNumber'];
                            $bikHeight = $_POST['bikHeight'];
                            $bikIsElectric = 0;
                            if(isset($_POST['bikIsElectric']))
                                $bikIsElectric = 1;
                            else
                                $bikIsElectric = 0;
                            ///////////////////////////////////////////////

                            $cityId = $_SESSION['idCity'];

                            ///La fonction qui ajoute un vélo dans la base de données retourne également l'ID du vélo qui vient d'être ajouté
                            $lastId = $dao->AddBikeToDatabase($bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $cityId);

                            //echo "<br><br><br><br><br><br><br><br><br><br>";

                            for($i=0;$i<count($newName);$i++)
                            {
                                //var_dump($newName);
                                //var_dump($lastId[0]['MAX(idBike)']);
                                $dao->AddPhotoToDatabase($newName[$i], $lastId[0]['MAX(idBike)']);
                            }

                            $_SESSION['uploadSuccess'] = 1;
                            header("location: ../views/addPage.php");
                            
                        }
                    }
                    else
                    {
                        echo "Un ou plusieurs attributs sont vides, remplissez correctement tous les formulaires";
                    }
                }
                else
                {
                    echo "Le formulaire n'a pas pu être envoyé correctement, réessayez.";
                }
            }
            else
            {
                echo "Les images sont trop volumineuses pour être uploadées ! Réessayez.";
            }
        }
        else
        {
            echo "submit btn not sent";
            //header("location: ../views/mainPage.php");
        }
    }
    else
    {
        echo "is not admin";
        //header("location: ../views/mainPage.php");
    }
}
else
{
    echo "Erreur lors de l'envoi du formulaire. Réessayez d'upload des images moins volumineuses.";
    //header("location: ../views/mainPage.php");
}



function RandomName($length) {
    $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

?>