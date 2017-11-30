<?php

/**
 * Created by PhpStorm.
 * User: Adrien
 */
//static
class  Database
{
    //prepare connection to prevent sql injection
    public $pdo;

    // get the database connection
    function __construct(){

        $this->pdo = null;

        try{
            $this->pdo = new PDO("mysql:host=" .HOST. ";dbname=" . DB, USER, PASS);

        }catch(PDOException $e){
            echo "Connection error: " . $e->getMessage();
        }

        return $this->pdo;
    }

    public function createFromId($id) {
        $stmt = $this->pdo->prepare("SELECT name FROM foo WHERE id=:id");
        $stmt->execute([
            ":id" => $id,
        ]);
        return $stmt->fetchObject();
    }



}