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

    function CreateCity($firstName, $lastName, $email, $phone, $cityName, $officeLocation, $npa)
    {
        $query = "INSERT INTO t_city (citContactFirstName, citContactLastName, citContactEmail, citContactPhone, citName, citNPA, citOfficeLocation)
        VALUES ({$firstName}, {$lastName}, {$email}, {$phone}, {$cityName}, {$officeLocation}, {$npa});";
        $this->ExecuteSetRequest($query);
    }

}


?>


