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
    ///Variable représentant le connecteur à la DB
    private $connector = null;

    ///Fonction pour se connecter à la base de données
    public function Connect()
    {
        ///Un try catch pour récupérer l'erreur et l'afficher si la connexion échoue
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

    function BindRequestAndExecuteGet($query, $params)
    {
        $this->Connect();

        $req = $this->connector->prepare($query);

        if(isset($params) && $params != null)
            $req->execute($params);
        else
            $req->execute();


        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $this->dbUnconnect();

        return $result;

    }

    function BindRequestAndExecuteSet($query, $params)
    {
        $this->Connect();

        $req = $this->connector->prepare($query);

        if(isset($params) && $params != null)
            $req->execute($params);
        else
            $req->execute();

        $this->dbUnconnect();

    }

    //Fonction qui récupére tous les vélos de la DB
    function GetAllBikes()
    {
        $result = $this->BindRequestAndExecuteGet("SELECT * FROM t_bikes", $params = null);

        return $result;
    }

    //Fonction qui récupére le nombre de vélo stockés dans la DB
    function GetNumberOfBikes()
    {
        $query = "SELECT COUNT(*) FROM t_bikes;";

        $params = null;

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Fonction qui ajoute une ville dans la table t_city et qui retourne l'ID de la ville qui vient d'être créée
    function CreateCity($firstName, $lastName, $email, $phone, $cityName, $officeLocation, $npa)
    {
        $query = "INSERT INTO t_city (citContactFirstName, citContactLastName, citContactEmail, citContactPhone, citName, citNPA, citOfficeLocation)
        VALUES (:firstName, :lastName, :email, :phone, :cityName, :npa, :officeLocation);";

        $params = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'cityName' => $cityName,
            'npa' => $npa,
            'officeLocation' => $officeLocation
        );

        $this->BindRequestAndExecuteSet($query, $params);

        //Recupère l'ID de la ville créée et la retourne
        $cityId = $this->GetCityId($cityName);
        return $cityId;
    }

    //Création d'un utilisateur admin (utilisé lors de la création d'une ville dans la DB)
    function CreateUserAdmin($username, $hashedPassword, $cityId, $firstName, $lastName, $phoneNumber, $email)
    {
        $query = "INSERT INTO t_user (useUsername, usePassword, useIsAdmin, useIsSuperAdmin, useFirstName, useLastName, usePhoneNumber, useEmail, idCity) VALUES (:username,:hashedPassword, 1, 0, :firstName, :lastName, :phoneNumber, :email , :cityId);";

        $params = array(
            'username' => $username,
            'hashedPassword' => $hashedPassword,
            'cityId' => $cityId,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'email' => $email
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    //Créer un utilisateur non-admin (uniquement les droits de recherche)
    function CreateUser($username, $hashedPassword, $cityId, $firstName, $lastName, $phoneNumber, $email)
    {
        $query = "INSERT INTO t_user (useUsername, usePassword, useIsAdmin, useIsSuperAdmin, useFirstName, useLastName, usePhoneNumber, useEmail, idCity) VALUES (:username,:hashedPassword, 0, 0, :firstName, :lastName, :phoneNumber, :email , :cityId);";

        $params = array(
            'username' => $username,
            'hashedPassword' => $hashedPassword,
            'cityId' => $cityId,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber,
            'email' => $email
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    //Recupére l'ID de la commune à partir du nom passé en paramètre
    function GetCityId($cityName)
    {
        $query = "SELECT idCity FROM t_city WHERE citName = :cityName";

        $params = array(
            ':cityName' => $cityName
        );
        
        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Recherche un utilisateur à partir de son username et retourne son username, password(hashé), si il est admin et super admin
    function SearchUser($username)
    {
        $query = "SELECT useUsername, usePassword, useIsAdmin, useIsSuperAdmin from t_user where useUsername = :username";

        $params = array(
            ':username' => $username
        );
        
        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Retourne toutes les villes de la base de données
    function GetAllCities()
    {
        $query = "SELECT citName from t_city;";

        $this->Connect();

        $req = $this->connector->prepare($query);


        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $this->dbUnconnect();

        return $result;
    }

    //Retourne toutes les marques de vélos de la table t_brands
    function GetAllBrands()
    {
        $query = "SELECT braName FROM t_brand;";

        $this->Connect();

        $req = $this->connector->prepare($query);

        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $this->dbUnconnect();

        return $result;
    }

    //Ajoute un vélo dans la base de données avec les informations fournies en paramètre et retourne l'ID du vélo qui vient d'être créé
    function AddBikeToDatabase($bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $idCity)
    {
        $query = "INSERT INTO t_bikes (bikeFoundDate, bikFoundLocation, bikBrand, bikColor, bikSerialNumber, bikHeight, bikIsElectric, bikHasBeenRetrieved, idCity) VALUES (:bikeFoundDate, :bikFoundLocation, :bikBrand, :bikColor, :bikSerialNumber, :bikHeight, :bikIsElectric, 0, :idCity);";

        $params = array(
            'bikeFoundDate' => $bikeFoundDate,
            'bikFoundLocation' => $bikFoundLocation,
            'bikBrand' => $bikBrand,
            'bikColor' => $bikColor,
            'bikSerialNumber' => $bikSerialNumber,
            'bikHeight' => $bikHeight,
            'bikIsElectric' => strval($bikIsElectric),
            'idCity' => $idCity
        );

        $this->BindRequestAndExecuteSet($query, $params);

        $query = "SELECT MAX(idBike) FROM t_bikes";

        $lastId = $this->BindRequestAndExecuteGet($query, $params = null);

        return $lastId;
    }

    //Ajoute une photo liée à un vélo dans la base de données
    function AddPhotoToDatabase($imagePath, $idBike)
    {
        $query = "INSERT INTO t_photo (phoPath, idBike) VALUES (:imagePath, :idBike);";

        $params = array(
            'imagePath' => $imagePath,
            'idBike' => $idBike
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    //Fonction utilisée lors de la recherche des vélos dans la DB, la variable $_POST est passée en paramètre
    //Afin de créer le string de la requête selon les paramètres qui ont été choisis
    function SearchInDatabase($POST)
    {
        //bool pour savoir si c'est le premier paramètre
        $isFirstParameter = true;
        $hasError = false;
        $params = array();

        //début du string de la requête
        $query = "SELECT * FROM t_bikes";

        //Assigne les valeurs de $POST à des variables indépendantes
        $bikBrand = '';
        if(isset($POST['bikBrand']))
            $params['bikBrand'] = htmlspecialchars($POST['bikBrand'], ENT_QUOTES);
        if(isset($POST['bikColor']))
            $params['bikColor'] = htmlspecialchars($POST['bikColor'], ENT_QUOTES);
        if(isset($POST['bikSerialNumber']) && $POST['bikSerialNumber'] != '')
            $params['bikSerialNumber'] = htmlspecialchars($POST['bikSerialNumber'], ENT_QUOTES);
        if(isset($POST['bikHeight']) && $POST['bikHeight'] != '')
            $params['bikHeight'] = htmlspecialchars($POST['bikHeight'], ENT_QUOTES);
        if(isset($POST['bikIsElectric']))
            $params['bikIsElectric'] = 1;
        /////////////////////////////////////////////////////////////

        $keys = array_keys($POST);

        foreach($keys as $key => $value)
        {
            if($value != 'bikBrand' && $value != 'bikColor' && $value != 'bikSerialNumber' && $value != 'bikHeight' && $value != 'bikIsElectric')
            {
                $hasError = true;
                break;
            }
        }


        //Boucle pour l'écriture de la requête
        foreach($params as $key => $value)
        {
            //Vérifie que le paramètre passé par le $POST n'est pas vide
            if($value != '')
            {
                //Si le paramètre n'est pas vide et que c'est le tout premier
                if($isFirstParameter)
                {
                    //Rajoute le "WHERE" + le nom de la clé du tableau $POST (qui correspond aux noms des colonnes de la base de données) et sa valeur
                    $query .= " WHERE {$key} = :$key";
                    //Mets la variable à FALSE car il n'ya plus besoin d'ajouter "WHERE" au début de la requête
                    $isFirstParameter = false;
                }
                //Si les autres paramètres ne sont pas vides et que le premier paramètre a été ajouté au string
                else
                {
                    //Rajoute "AND" + le nom de la clé du tableau $POST et sa valeur
                    $query .= " AND {$key} = :$key";
                }
            }
        }
        $query .= ";";

        var_dump($query);


        if(!$hasError)
        {
            //Exécute la requête et retourne le résultat
            if($isFirstParameter == true)
                return $this->BindRequestAndExecuteGet($query, $params = null);
            else
                return $this->BindRequestAndExecuteGet($query, $params);
        }
        else
        {
            echo "<br><br><br><p>Il y'a eu une erreur lors de l'envoi de la requête, action annulée !</p>";
        }
    }

    //Récupère la(les) photos liés au vélo passé en paramètre
    function GetPhotosLinkedToBike($idBike)
    {
        $query = "SELECT phoPath FROM t_photo WHERE idBike = :idBike;";

        $params = array(
            'idBike' => $idBike
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Recupère toutes les infos sur un vélo à partir de l'ID
    function GetBikeInfos($idBike)
    {
        $query = "SELECT * from t_bikes WHERE idBike = :idBike;";

        $params = array(
            'idBike' => $idBike
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Récupère le nom 
    function GetCityName($idCity)
    {
        $query = "SELECT citName FROM t_city WHERE idCity = :idCity;";

        $params = array(
            'idCity' => $idCity
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Fonction qui récupère le nom de toutes les couleurs dans la table t_color
    function GetAllColorNames()
    {
        $query = "SELECT colName FROM t_color;";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    //Fonction qui récupère tous les receveurs de la table t_receiver
    function GetAllReceiver()
    {
        $query = "SELECT recLastName, recFirstName, idReceiver FROM t_receiver";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    //Fonction qui récupère tous les donneurs de la table t_giver
    function GetAllGiver()
    {
        $query = "SELECT givLastName, givFirstName, idGiver FROM t_giver";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    function SetReceiverAndGiverOfBike($idBike, $idReceiver, $idGiver, $actualDate)
    {
        $query = "UPDATE t_bikes SET idReceiver = :idReceiver, idGiver = :idGiver, bikHasBeenRetrieved = 1, bikRetrieveDate = :actualDate WHERE idBike = :idBike;";

        $params = array(
            'idBike' => $idBike,
            'idReceiver' => $idReceiver,
            'idGiver' => $idGiver,
            'actualDate' => $actualDate,
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    function GetReceiverInfos($idReceiver)
    {
        $query = "SELECT * FROM t_receiver WHERE idReceiver = :idReceiver";

        $params = array(
            'idReceiver' => $idReceiver
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    function GetGiverInfos($idGiver)
    {
        $query = "SELECT * FROM t_giver WHERE idGiver = :idGiver";

        $params = array(
            'idGiver' => $idGiver
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    function AddReceiverToDb($firstName, $lastName, $email, $phoneNumber)
    {
        $query = "INSERT INTO t_receiver (recFirstName, recLastName, recEmail, recPhoneNumber) VALUES (:firstName,:lastName,:email,:phoneNumber);";

        $params = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    function AddGiverToDb($firstName, $lastName, $email, $phoneNumber)
    {
        $query = "INSERT INTO t_giver (givFirstName, givLastName, givEmail, givPhoneNumber) VALUES (:firstName,:lastName,:email,:phoneNumber);";

        $params = array(
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    function UpdateBike($idBike, $bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $bikRetrieveDate)
    {
        $query = "UPDATE t_bikes SET bikeFoundDate = :bikeFoundDate, bikFoundLocation = :bikFoundLocation, bikBrand = :bikBrand, bikColor = :bikColor, bikSerialNumber = :bikSerialNumber, bikHeight = :bikHeight, bikIsElectric = :bikIsElectric, bikRetrieveDate = :bikRetrieveDate WHERE idBike = :idBike;";
        
        $params = array(
            'idBike' => $idBike,
            'bikeFoundDate' => $bikeFoundDate,
            'bikFoundLocation' => $bikFoundLocation,
            'bikBrand' => $bikBrand,
            'bikColor' => $bikColor,
            'bikSerialNumber' => $bikSerialNumber,
            'bikHeight' => $bikHeight,
            'bikIsElectric' => $bikIsElectric,
            'bikRetrieveDate' => $bikRetrieveDate
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    function ResetRecieverAndGiver($idBike)
    {
        $query = "UPDATE t_bikes SET idReceiver = NULL, idGiver = NULL, bikHasBeenRetrieved = 0, bikRetrieveDate = NULL WHERE idBike = :idBike;";

        $params = array(
            'idBike' => $idBike
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    function GetBikesRetrievedByQuarter()
    {
        $query = "SELECT YEAR(bikRetrieveDate) AS year, QUARTER(bikRetrieveDate) AS quarter, COUNT(idBike) AS numberOfBikes
                    FROM t_bikes
                    GROUP BY YEAR(bikRetrieveDate), QUARTER(bikRetrieveDate)
                    ORDER BY YEAR(bikRetrieveDate), QUARTER(bikRetrieveDate)";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    function GetBikesRetrievedByYear()
    {
        $query = "SELECT YEAR(bikRetrieveDate) AS year, COUNT(idBike) AS numberOfBikes FROM t_bikes WHERE bikHasBeenRetrieved = 1 GROUP BY YEAR(bikRetrieveDate) ORDER BY YEAR(bikRetrieveDate)";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    function CheckIfUserAlreadyExist($username)
    {
        $query = "SELECT useUsername FROM t_user WHERE useUsername = :username";

        $params = array(
            'username' => $username
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

}


?>