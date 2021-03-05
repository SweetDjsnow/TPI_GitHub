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

    //Fonction prenant en paramètre la requete SQL puis l'exécute et retourne le résultat sous forme de tableau (utilisé uniquement pour les requêtes pour récupérer des données, pas de UPDATE ou INSERT INTO etc...)
    function ExecuteGetRequest($query)
    {
        $this->Connect();

        $req = $this->connector->prepare($query);

        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        $this->dbUnconnect();


        return $result;

    }


    ///Fonction prenant en paramètre la requête SQL pour exécuter une requête qui modifie ou ajoute du contenu dans la base de données
    function ExecuteSetRequest($query)
    {
        $this->Connect();

        $req = $this->connector->prepare($query);

        $req->execute();

        $this->dbUnconnect();

    }

    //Fonction qui récupére tous les vélos de la DB
    function GetAllBikes()
    {
        $result = $this->ExecuteGetRequest("SELECT * FROM t_bikes");

        return $result;
    }

    //Fonction qui récupére le nombre de vélo stockés dans la DB
    function GetNumberOfBikes()
    {
        $query = "SELECT COUNT(*) FROM t_bikes;";
        return $this->ExecuteGetRequest($query);
    }

    //Fonction qui ajoute une ville dans la table t_city et qui retourne l'ID de la ville qui vient d'être créée
    function CreateCity($firstName, $lastName, $email, $phone, $cityName, $officeLocation, $npa)
    {
        $query = "INSERT INTO t_city (citContactFirstName, citContactLastName, citContactEmail, citContactPhone, citName, citNPA, citOfficeLocation)
        VALUES ('{$firstName}', '{$lastName}', '{$email}', '{$phone}', '{$cityName}', '{$npa}', '{$officeLocation}');";
        $this->ExecuteSetRequest($query);

        //Recupère l'ID de la ville créée et la retourne
        $cityId = $this->GetCityId($cityName);
        return $cityId;
    }

    //Création d'un utilisateur admin (utilisé lors de la création d'une ville dans la DB)
    function CreateUserAdmin($username, $hashedPassword, $cityId, $firstName, $lastName, $phoneNumber, $email)
    {
        $query = "INSERT INTO t_user (useUsername, usePassword, useIsAdmin, useIsSuperAdmin, useFirstName, useLastName, usePhoneNumber, useEmail, idCity) VALUES ('{$username}','{$hashedPassword}', 1, 0, '{$firstName}', '{$lastName}', '{$phoneNumber}', '{$email}' , {$cityId});";
        $this->ExecuteSetRequest($query);
    }

    //Créer un utilisateur non-admin (uniquement les droits de recherche)
    function CreateUser($username, $hashedPassword, $cityId, $firstName, $lastName, $phoneNumber, $email)
    {
        $query = "INSERT INTO t_user (useUsername, usePassword, useIsAdmin, useIsSuperAdmin, useFirstName, useLastName, usePhoneNumber, useEmail, idCity) VALUES ('{$username}','{$hashedPassword}', 0, 0, '{$firstName}', '{$lastName}', '{$phoneNumber}', '{$email}' , {$cityId});";
        $this->ExecuteSetRequest($query);
    }

    //Recupére l'ID de la commune à partir du nom passé en paramètre
    function GetCityId($cityName)
    {
        $query = "SELECT idCity FROM t_city WHERE citName = '{$cityName}'";
        return $this->ExecuteGetRequest($query);
    }

    //Recherche un utilisateur à partir de son username et retourne son username, password(hashé), si il est admin et super admin
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

    
    /*function GetBikeBrand($bikBrand)
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
    }*/

    //Retourne toutes les villes de la base de données
    function GetAllCities()
    {
        $query = "SELECT citName from t_city;";

        return $this->ExecuteGetRequest($query);
    }

    //Retourne toutes les marques de vélos de la table t_brands
    function GetAllBrands()
    {
        $query = "SELECT braName FROM t_brand;";

        return $this->ExecuteGetRequest($query);
    }

    //Ajoute un vélo dans la base de données avec les informations fournies en paramètre et retourne l'ID du vélo qui vient d'être créé
    function AddBikeToDatabase($bikeFoundDate, $bikFoundLocation, $bikBrand, $bikColor, $bikSerialNumber, $bikHeight, $bikIsElectric, $idCity)
    {
        $query = "INSERT INTO t_bikes (bikeFoundDate, bikFoundLocation, bikBrand, bikColor, bikSerialNumber, bikHeight, bikIsElectric, bikHasBeenRetrieved, idCity) VALUES ('{$bikeFoundDate}', '{$bikFoundLocation}', '{$bikBrand}', '{$bikColor}', '{$bikSerialNumber}', '{$bikHeight}', {$bikIsElectric}, 0, {$idCity});";

        $this->ExecuteSetRequest($query);

        var_dump($query);

        $query = "SELECT MAX(idBike) FROM t_bikes";

        return $this->ExecuteGetRequest($query);
    }

    //Ajoute une photo liée à un vélo dans la base de données
    function AddPhotoToDatabase($imagePath, $idBike)
    {
        $query = "INSERT INTO t_photo (phoPath, idBike) VALUES ('{$imagePath}', {$idBike});";

        $this->ExecuteSetRequest($query);
    }

    //Fonction utilisée lors de la recherche des vélos dans la DB, la variable $_POST est passée en paramètre
    //Afin de créer le string de la requête selon les paramètres qui ont été choisis
    function SearchInDatabase($POST)
    {
        //bool pour savoir si c'est le premier paramètre
        $isFirstParameter = true;

        //début du string de la requête
        $query = "SELECT * FROM t_bikes";

        //Assigne les valeurs de $POST à des variables indépendantes
        $bikBrand = '';
        if(isset($POST['bikBrand']))
            $bikBrand = $POST['bikBrand'];
        if(isset($POST['bikColor']))
            $bikColor = $POST['bikColor'];
        $bikSerialNumber = $POST['bikSerialNumber'];
        $bikHeight = $POST['bikHeight'];
        if(isset($POST['bikIsElectric']))
            $POST['bikIsElectric'] = 1;
        /////////////////////////////////////////////////////////////


        //Boucle pour l'écriture de la requête
        foreach($POST as $key => $value)
        {
            //Vérifie que le paramètre passé par le $POST n'est pas vide
            if($value != '')
            {
                //Si le paramètre n'est pas vide et que c'est le tout premier
                if($isFirstParameter)
                {
                    //Rajoute le "WHERE" + le nom de la clé du tableau $POST (qui correspond aux noms des colonnes de la base de données) et sa valeur
                    $query .= " WHERE {$key} = '{$value}'";
                    //Mets la variable à FALSE car il n'ya plus besoin d'ajouter "WHERE" au début de la requête
                    $isFirstParameter = false;
                }
                //Si les autres paramètres ne sont pas vides et que le premier paramètre a été ajouté au string
                else
                {
                    //Rajoute "AND" + le nom de la clé du tableau $POST et sa valeur
                    $query .= " AND {$key} = '{$value}'";
                }
            }
        }
        $query .= ";";

        //Exécute la requête et retourne le résultat
        return $this->ExecuteGetRequest($query);
    }

    //Récupère la(les) photos liés au vélo passé en paramètre
    function GetPhotosLinkedToBike($idBike)
    {
        $query = "SELECT phoPath FROM t_photo WHERE idBike = {$idBike};";

        return $this->ExecuteGetRequest($query);
    }

    //Recupère toutes les infos sur un vélo à partir de l'ID
    function GetBikeInfos($idBike)
    {
        $query = "SELECT * from t_bikes WHERE idBike = {$idBike};";
        var_dump($query);

        return $this->ExecuteGetRequest($query);
    }

    //Récupère le nom 
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