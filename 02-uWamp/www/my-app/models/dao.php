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
            $this->connector= new PDO('mysql:host=localhost;dbname=db_findbike21','findbike21_user','Dds7g?ft7n3KT');

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

    //Fonction qui reçoit la requête SQL et un tableau des paramètres pour bind et exécuter
    //une requête GET (SELECT, etc...)
    function BindRequestAndExecuteGet($query, $params)
    {
        //Se connecte à la base de donnée
        $this->Connect();

        //Prépare la requête
        $req = $this->connector->prepare($query);

        //Si les paramètres ne sont pas null, execute avec le tableau en paramètre
        //Sinon exécute simplement la requête sans rien bind
        if(isset($params) && $params != null)
            $req->execute($params);
        else
            $req->execute();


        //Fetch les résultats en tableau associatif
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        
        //Déconnecte de la base de données
        $this->dbUnconnect();

        //Retourne les résultats
        return $result;

    }

    //Fonction qui reçoit la requête SQL et un tableau des paramètres pour bind et exécuter
    //une requête qui ajoute du contenu ou en modifie (Insert, update, etc...). Ne retourne pas de résultat
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

    function AddBrand($brand)
    {
        $query = "INSERT INTO t_brand (braName) VALUES (:brand)";

        $params = array(
            'brand' => $brand
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    function AddColor($color)
    {
        $query = "INSERT INTO t_color (colName) VALUES (:color)";

        $params = array(
            'color' => $color
        );

        $this->BindRequestAndExecuteSet($query, $params);
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
        $query = "SELECT useUsername, usePassword, useIsAdmin, useIsSuperAdmin, idCity from t_user where useUsername = :username";

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
        $query = "SELECT braName FROM t_brand ORDER BY braName ASC;";

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
    function SearchInDatabase($POST, $offset, $resultsPerPage)
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
        if(isset($POST['bikHasBeenRetrieved']))
        {
            if($POST['bikHasBeenRetrieved'] == 'on')
            {
                $params['bikHasBeenRetrieved'] = 1;
            }
        }
        else
            $params['bikHasBeenRetrieved'] = 0;
        /////////////////////////////////////////////////////////////

        //Récupère les clés du tableau associatif
        $keys = array_keys($POST);

        //Pour chaque clés dans le tableau, vérifie que le nom de l'input est correct
        //Si ce n'est pas le cas, la requête affichera une erreur
        foreach($keys as $key => $value)
        {
            if($value != 'bikBrand' && $value != 'bikColor' && $value != 'bikSerialNumber' && $value != 'bikHeight' && $value != 'bikIsElectric' && $value != 'bikHasBeenRetrieved')
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
                    if($key == 'bikHasBeenRetrieved')
                    {
                        if($params['bikHasBeenRetrieved'] == 1)
                        {
                            $query .= " WHERE ({$key} = :$key OR {$key} = 0)";
                            $isFirstParameter = false;
                        }
                        else
                        {
                            $query .= " WHERE {$key} = :$key";
                            $isFirstParameter = false;
                        }
                    }
                    else
                    {
                        $query .= " WHERE {$key} = :$key";
                    }
                    //Mets la variable à FALSE car il n'ya plus besoin d'ajouter "WHERE" au début de la requête
                    $isFirstParameter = false;
                }
                //Si les autres paramètres ne sont pas vides et que le premier paramètre a été ajouté au string
                else
                {
                    //Rajoute "AND" + le nom de la clé du tableau $POST et sa valeur
                    if($key == 'bikHasBeenRetrieved')
                    {
                        if($params['bikHasBeenRetrieved'] == 1)
                        {
                            $query .= " AND ({$key} = :$key OR {$key} = 0)";
                        }
                        else
                        {
                            $query .= " AND {$key} = :$key";
                        }
                    }
                    else
                    {
                        $query .= " AND {$key} = :$key";
                    }
                }
            }
        }
        $query .= " LIMIT $offset, $resultsPerPage;";

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
            echo "Il y'a eu une erreur lors de l'envoi de la requête, action annulée !</p>";
        }
    }

    function CountAllResults($POST)
    {
        //bool pour savoir si c'est le premier paramètre
        $isFirstParameter = true;
        $hasError = false;
        $params = array();


        //début du string de la requête
        $query = "SELECT COUNT(*) FROM t_bikes";

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
        if(isset($POST['bikHasBeenRetrieved']))
        {
            if($POST['bikHasBeenRetrieved'] == 'on')
            {
                $params['bikHasBeenRetrieved'] = 1;
            }
        }
        else
            $params['bikHasBeenRetrieved'] = 0;
        
        /////////////////////////////////////////////////////////////

        //Récupère les clés du tableau associatif
        $keys = array_keys($POST);

        //Pour chaque clés dans le tableau, vérifie que le nom de l'input est correct
        //Si ce n'est pas le cas, la requête affichera une erreur
        foreach($keys as $key => $value)
        {
            if($value != 'bikBrand' && $value != 'bikColor' && $value != 'bikSerialNumber' && $value != 'bikHeight' && $value != 'bikIsElectric' && $value != 'bikHasBeenRetrieved')
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
                    if($key == 'bikHasBeenRetrieved')
                    {
                        if($params['bikHasBeenRetrieved'] == 1)
                        {
                            $query .= " WHERE ({$key} = :$key OR {$key} = 0)";
                            $isFirstParameter = false;
                        }
                        else
                        {
                            $query .= " WHERE {$key} = :$key";
                            $isFirstParameter = false;
                        }
                    }
                    else
                    {
                        $query .= " WHERE {$key} = :$key";
                    }
                    //Mets la variable à FALSE car il n'ya plus besoin d'ajouter "WHERE" au début de la requête
                    $isFirstParameter = false;
                }
                //Si les autres paramètres ne sont pas vides et que le premier paramètre a été ajouté au string
                else
                {
                    //Rajoute "AND" + le nom de la clé du tableau $POST et sa valeur
                    if($key == 'bikHasBeenRetrieved')
                    {
                        if($params['bikHasBeenRetrieved'] == 1)
                        {
                            $query .= " AND ({$key} = :$key OR {$key} = 0)";
                        }
                        else
                        {
                            $query .= " AND {$key} = :$key";
                        }
                    }
                    else
                    {
                        $query .= " AND {$key} = :$key";
                    }
                }
            }
        }
        $query .= ";";



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
            echo "Il y'a eu une erreur lors de l'envoi de la requête, action annulée !</p>";
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

    //Récupère tous les noms des couleurs de la base de données
    function GetAllColorNames()
    {
        $query = "SELECT colName FROM t_color ORDER BY colName ASC;";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    //Recupère tous les receveurs de la base de données
    function GetAllReceiver()
    {
        $query = "SELECT recLastName, recFirstName, idReceiver FROM t_receiver";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    //Recupère tous les donneurs de la base de données
    function GetAllGiver()
    {
        $query = "SELECT givLastName, givFirstName, idGiver FROM t_giver";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    //Update le receveur et le donneur d'un vélo. Cette fonction est appelée lorsque l'utilisateur
    //rend un vélo.
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

    //Recupère toutes les informations concernant le receveur avec l'id passé en paramètre
    function GetReceiverInfos($idReceiver)
    {
        $query = "SELECT * FROM t_receiver WHERE idReceiver = :idReceiver";

        $params = array(
            'idReceiver' => $idReceiver
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Recupère toutes les informations concernant le donneur avec l'id passé en paramètre
    function GetGiverInfos($idGiver)
    {
        $query = "SELECT * FROM t_giver WHERE idGiver = :idGiver";

        $params = array(
            'idGiver' => $idGiver
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Ajoute un receveur dans la base de données avec les informations passées en paramètre
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

    //Ajoute un donneur à la base de données avec les informations passées en paramètre
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

    //Update toutes les informations d'un vélo avec les données passées en paramètre
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

    //Mets à jour l'id du receveur et donneur d'un vélo a NULL et le bool qui définit si le vélo a été
    //rendu à 0
    function ResetRecieverAndGiver($idBike)
    {
        $query = "UPDATE t_bikes SET idReceiver = NULL, idGiver = NULL, bikHasBeenRetrieved = 0, bikRetrieveDate = NULL WHERE idBike = :idBike;";

        $params = array(
            'idBike' => $idBike
        );

        $this->BindRequestAndExecuteSet($query, $params);
    }

    //Recupère tous les vélos qui ont été rendus par trimestre
    function GetBikesRetrievedByQuarter()
    {
        $query = "SELECT YEAR(bikRetrieveDate) AS year, QUARTER(bikRetrieveDate) AS quarter, COUNT(idBike) AS numberOfBikes
                    FROM t_bikes
                    GROUP BY YEAR(bikRetrieveDate), QUARTER(bikRetrieveDate)
                    ORDER BY YEAR(bikRetrieveDate), QUARTER(bikRetrieveDate)";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    //Recupère tous les vélos qui ont été rendu pour chaques années
    function GetBikesRetrievedByYear()
    {
        $query = "SELECT YEAR(bikRetrieveDate) AS year, COUNT(idBike) AS numberOfBikes FROM t_bikes WHERE bikHasBeenRetrieved = 1 GROUP BY YEAR(bikRetrieveDate) ORDER BY YEAR(bikRetrieveDate)";

        return $this->BindRequestAndExecuteGet($query, $params = null);
    }

    //Fonction utilisée pour vérifier si un utilisateur est déjà dans la base de données
    function CheckIfUserAlreadyExist($username)
    {
        $query = "SELECT useUsername FROM t_user WHERE useUsername = :username";

        $params = array(
            'username' => $username
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    //Vérifie si le vélo existe à partir de l'ID
    function CheckIfBikeExists($id)
    {
        $query = "SELECT COUNT(*) FROM t_bikes WHERE idBike = :idBike";

        $params = array(
            'idBike' => $id
        );

        return $this->BindRequestAndExecuteGet($query, $params);
    }

    function DeleteBike($id)
    {
        $query = "DELETE FROM t_photo WHERE idBike = :idBike";

        $params = array(
            'idBike' => $id
        );

        $this->BindRequestAndExecuteSet($query, $params);

        $query = "DELETE FROM t_bikes WHERE idBike = :idBike";

        $this->BindRequestAndExecuteSet($query, $params);
    }
    
}


?>