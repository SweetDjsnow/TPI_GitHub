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

    function CreateUser($username, $hashedPassword, $cityId, $firstName, $lastName, $phoneNumber, $email)
    {
        $query = "INSERT INTO t_user (useUsername, usePassword, useIsAdmin, useIsSuperAdmin, useFirstName, useLastName, usePhoneNumber, useEmail, idCity) VALUES ('{$username}','{$hashedPassword}', 0, 0, '{$firstName}', '{$lastName}', '{$phoneNumber}', '{$email}' , {$cityId});";
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
        $query = "INSERT INTO t_bikes (bikeFoundDate, bikFoundLocation, bikBrand, bikColor, bikSerialNumber, bikHeight, bikIsElectric, bikHasBeenRetrieved, idCity) VALUES ('{$bikeFoundDate}', '{$bikFoundLocation}', '{$bikBrand}', '{$bikColor}', '{$bikSerialNumber}', '{$bikHeight}', {$bikIsElectric}, 0, {$idCity});";

        var_dump($query);
        $this->ExecuteSetRequest($query);

        $query = "SELECT MAX(idBike) FROM t_bikes";

        return $this->ExecuteGetRequest($query);
    }

    function AddPhotoToDatabase($imagePath, $idBike)
    {
        $query = "INSERT INTO t_photo (phoPath, idBike) VALUES ('{$imagePath}', {$idBike});";

        $this->ExecuteSetRequest($query);
    }

    function SearchInDatabase($POST)
    {
        $isFirstParameter = true;

        $query = "SELECT * FROM t_bikes";

        $bikBrand = '';
        if(isset($POST['bikBrand']))
            $bikBrand = $POST['bikBrand'];
        if(isset($POST['bikColor']))
            $bikColor = $POST['bikColor'];
        $bikSerialNumber = $POST['bikSerialNumber'];
        $bikHeight = $POST['bikHeight'];

        if(isset($POST['bikIsElectric']))
        {
            $POST['bikIsElectric'] = 1;
        }


        foreach($POST as $key => $value)
        {
            if($isFirstParameter)
            {
                if($value != '')
                {
                    $query .= " WHERE {$key} = '{$value}'";
                    $isFirstParameter = false;
                }
            }
            else
            {
                if($value != '')
                    $query .= " AND {$key} = '{$value}'";
            }
        }
        $query .= ";";

        var_dump($query);

        return $this->ExecuteGetRequest($query);
    }

    function GetPhotosLinkedToBike($idBike)
    {
        $query = "SELECT phoPath FROM t_photo WHERE idBike = {$idBike};";

        return $this->ExecuteGetRequest($query);
    }

    function GetBikeInfos($idBike)
    {
        $query = "SELECT * from t_bikes WHERE idBike = {$idBike};";

        return $this->ExecuteGetRequest($query);
    }

    function GetCityName($idCity)
    {
        $query = "SELECT citName FROM t_city WHERE idCity = {$idCity};";

        return $this->ExecuteGetRequest($query);
    }

    function GetAllColorNames()
    {
        $query = "SELECT colName FROM t_color;";

        return $this->ExecuteGetRequest($query);
    }

    function GetAllReceiver()
    {
        $query = "SELECT recLastName, recFirstName, idReceiver FROM t_receiver";

        return $this->ExecuteGetRequest($query);
    }

    function GetAllGiver()
    {
        $query = "SELECT givLastName, givFirstName, idGiver FROM t_giver";

        return $this->ExecuteGetRequest($query);
    }

    function SetReceiverAndGiverOfBike($idBike, $idReceiver, $idGiver, $actualDate)
    {
        $query = "UPDATE t_bikes SET idReceiver = {$idReceiver}, idGiver = {$idGiver}, bikHasBeenRetrieved = 1, bikRetrieveDate = '{$actualDate}' WHERE idBike = {$idBike};";

        var_dump($query);

        $this->ExecuteSetRequest($query);
    }

    function GetReceiverInfos($idReceiver)
    {
        $query = "SELECT * FROM t_receiver WHERE idReceiver = {$idReceiver}";

        return $this->ExecuteGetRequest($query);
    }

    function GetGiverInfos($idGiver)
    {
        $query = "SELECT * FROM t_giver WHERE idGiver = {$idGiver}";

        return $this->ExecuteGetRequest($query);
    }

    function AddReceiverToDb($firstName, $lastName, $email, $phoneNumber)
    {
        $query = "INSERT INTO t_receiver (recFirstName, recLastName, recEmail, recPhoneNumber) VALUES ('{$firstName}','{$lastName}','{$email}','{$phoneNumber}');";

        var_dump($query);

        $this->ExecuteSetRequest($query);
    }

    function AddGiverToDb($firstName, $lastName, $email, $phoneNumber)
    {
        $query = "INSERT INTO t_giver (givFirstName, givLastName, givEmail, givPhoneNumber) VALUES ('{$firstName}','{$lastName}','{$email}','{$phoneNumber}');";

        $this->ExecuteSetRequest($query);
    }

    function UpdateBike($idBike, $bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $bikRetrieveDate)
    {
        $query = "UPDATE t_bikes SET bikeFoundDate = '{$bikeFoundDate}', bikFoundLocation = '{$bikFoundLocation}', bikBrand = '{$bikBrand}', bikColor = '{$bikColor}', bikSerialNumber = '{$bikSerialNumber}', bikHeight = '{$bikHeight}', bikIsElectric = {$bikIsElectric}, bikRetrieveDate = '{$bikRetrieveDate}' WHERE idBike = {$idBike};";
        
        $this->ExecuteSetRequest($query);
    }

    function ResetRecieverAndGiver($idBike)
    {
        $query = "UPDATE t_bikes SET idReceiver = NULL, idGiver = NULL, bikHasBeenRetrieved = 0, bikRetrieveDate = NULL WHERE idBike = {$idBike};";

        $this->ExecuteSetRequest($query);
    }

    function GetBikesRetrievedByQuarter()
    {
        $query = "SELECT YEAR(bikRetrieveDate) AS year, QUARTER(bikRetrieveDate) AS quarter, COUNT(idBike) AS numberOfBikes
                    FROM t_bikes
                    GROUP BY YEAR(bikRetrieveDate), QUARTER(bikRetrieveDate)
                    ORDER BY YEAR(bikRetrieveDate), QUARTER(bikRetrieveDate)";

        return $this->ExecuteGetRequest($query);
    }

    function GetBikesRetrievedByYear()
    {
        $query = "SELECT YEAR(bikRetrieveDate) AS year, COUNT(idBike) AS numberOfBikes FROM t_bikes WHERE bikHasBeenRetrieved = 1 GROUP BY YEAR(bikRetrieveDate) ORDER BY YEAR(bikRetrieveDate)";

        return $this->ExecuteGetRequest($query);
    }

}


?>