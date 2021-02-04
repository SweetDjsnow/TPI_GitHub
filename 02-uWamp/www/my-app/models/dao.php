<?php

/*********************
*
* Auteur: Michel Dos Santos Constantino
* Date: 04.06.2019
* Lieu: ETML
* Description: Fichier de la classe modèle qui sert à rechercher des données dans la base de données
*
**********************/

class Database
{
    
    private $connector = null;

    public function Connect()
    {
        try
        {
            $this->connector= new PDO('mysql:host=localhost;dbname=db_pre_tpi','root','root');

        }
        catch (Exception $e)
        {
            echo $e;
        }
    }

    //Fonction pour se déconnecter
    public function dbUnconnect()
    {
        try
        {
            $this->connector = null;
        }
        catch (Exception $e)
        {
            echo $e;
        }
    }

    function ExecuteGetRequest($query)
    {
        $this->Connect();

        $req = $this->connector->prepare($query);

        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $this->dbUnconnect();


        return $result;

    }

    function ExecuteSetRequest($query)
    {
        $this->Connect();

        $req = $this->connector->prepare($query);

        $req->execute();

        $this->dbUnconnect();

    }

    function GetAllBikes()
    {
        $result = $this->ExecuteGetRequest("SELECT * FROM t_bikes");

        return $result;
    }

    function GetNumberOfBikes()
    {
        $query = "SELECT COUNT(*) FROM t_bikes;";
        return $this->ExecuteGetRequest($query);
    }

    function CreateCity($firstName, $lastName, $email, $phone, $cityName, $officeLocation, $npa)
    {
        $query = "INSERT INTO t_city (citContactFirstName, citContactLastName, citContactEmail, citContactPhone, citName, citNPA, citOfficeLocation)
        VALUES ('{$firstName}', '{$lastName}', '{$email}', '{$phone}', '{$cityName}', '{$npa}', '{$officeLocation}');";
        $this->ExecuteSetRequest($query);

        $cityId = $this->GetCityId($cityName);
        return $cityId;
    }

    function CreateUserAdmin($username, $hashedPassword, $cityId, $firstName, $lastName, $phoneNumber, $email)
    {
        $query = "INSERT INTO t_user (useUsername, usePassword, useIsAdmin, useIsSuperAdmin, useFirstName, useLastName, usePhoneNumber, useEmail, idCity) VALUES ('{$username}','{$hashedPassword}', 1, 0, '{$firstName}', '{$lastName}', '{$phoneNumber}', '{$email}' , {$cityId});";
        $this->ExecuteSetRequest($query);
        echo $query;
    }

    function GetCityId($cityName)
    {
        $query = "SELECT idCity FROM t_city WHERE citName = '{$cityName}'";
        return $this->ExecuteGetRequest($query);
    }

    function SearchUser($username)
    {
        $query = "SELECT useUsername, usePassword, useIsAdmin, useIsSuperAdmin from t_user where useUsername = ?";

        $this->Connect();

        $req = $this->connector->prepare($query);
        $req->bindValue(1,$username, PDO::PARAM_STR);
        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $this->dbUnconnect();


        return $result;
    }

    function GetBikeBrand($bikBrand)
    {
        $query = "SELECT bikBrand from t_bikes WHERE bikBrand = '{$bikBrand}';";

        return $this->ExecuteGetRequest($query);
    }

    function GetBikeColor($bikColor)
    {
        $query = "SELECT bikColor from t_bikes WHERE bikColor = '{$bikColor}';";

        return $this->ExecuteGetRequest($query);
    }

    function GetBikeHeight($bikHeight)
    {
        $query = "SELECT bikHeight from t_bikes WHERE bikHeight = '{$bikHeight}';";

        return $this->ExecuteGetRequest($query);
    }

    function GetBikeSerialNumber($bikSerialNumber)
    {
        $query = "SELECT bikSerialNumber from t_bikes WHERE bikSerialNumber = '{$bikSerialNumber}';";

        return $this->ExecuteGetRequest($query);
    }

    function GetAllCities()
    {
        $query = "SELECT citName from t_city;";

        return $this->ExecuteGetRequest($query);
    }

    function GetAllBrands()
    {
        $query = "SELECT braName FROM t_brand;";

        return $this->ExecuteGetRequest($query);
    }

    function AddBikeToDatabase($bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $idCity)
    {
        $query = "INSERT INTO t_bikes (bikeFoundDate, bikFoundLocation, bikBrand, bikColor, bikSerialNumber, bikHeight, bikIsElectric, bikHasBeenRetrieved, bikRetrievedBy, bikGivenBy, idCity) VALUES ('{$bikeFoundDate}', '{$bikFoundLocation}', '{$bikBrand}', '{$bikColor}', '{$bikSerialNumber}', '{$bikHeight}', {$bikIsElectric}, 0, 'null', 'null', {$idCity});";

        $this->ExecuteSetRequest($query);

        $query = "SELECT MAX(idBike) FROM t_bikes";

        return $this->ExecuteGetRequest($query);
    }

    function AddPhotoToDatabase($imagePath, $idBike)
    {
        $query = "INSERT INTO t_photo (phoPath, idBike) VALUES ('{$imagePath}', {$idBike});";

        $this->ExecuteSetRequest($query);
    }


}


?>


