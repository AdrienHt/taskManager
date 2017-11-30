<?php

/**
 * Created by PhpStorm.
 * User: Adrien
 */
class User
{
    private $table_name = "users";

    private $id;
    private $name;
    private $email;

    /**
     * User constructor.
     * @param string $table_name
     * @param $id
     * @param $name
     * @param $email
     */

    public function __construct($id, $name, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public static function getAllUsers()
    {

        $db = new Database();

        $stmt =  $db->pdo->prepare("SELECT * FROM users");

        $stmt->execute();

        //Close connection
        $usersArray = array();
        $usersArray['users'] = array();

        if ($stmt->rowCount()>0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                //$user = new user($row['id'], $row['name'], $row['email']);
                $user = array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "email" => $row['email']
                );
                array_push($usersArray['users'], $user);
            }
        } else {
            return "No users in the database";
        }

        return $usersArray;
    }

    public static function getUserByID($id){

        $db = new Database();

        $stmt =  $db->pdo->prepare("SELECT * FROM users WHERE id=:id");

        $stmt->execute([
            ":id" => $id,
        ]);

        return $stmt->fetchObject();
    }

    public static function getUserByName($name){
        $db = new Database();

        $stmt =  $db->pdo->prepare("SELECT * FROM users WHERE name=:name");

        $stmt->execute([
            ":name" => $name,
        ]);

        return $stmt->fetchObject();
    }

    //user/add
    public static function addUser($data){
        if (empty($data)){
            return "Error :Nothing was send";
        }

        $errors = [];

        if (empty($data['name']) || !preg_match('/^[A-Za-z][A-Za-z0-9]{2,31}$/', $data['name']) || user::getUserByName($data['name'])) {
            $errors['name'] = "Error: User already exist or invalid";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || user::checkMailAdress($data['email'])) {
            $errors['email'] = "Error: Mail adress already exist or is not valid";
        }

        if (!empty($errors)){
            return $errors;
        }

        $db = new Database();
        $stmt =  $db->pdo->prepare("INSERT INTO users(name, email) VALUES (:name, :email)");

        if ($stmt->execute(array(
            "name" => $data['name'],
            "email" => $data['email']
        ))){
            return "202 : Success";
        } else {
            return "Error during the insertion";
        }

    }

    //user/delete/id
    public static function deleteUser($id){
        if (!self::getUserByID($id)){
            return "404: User . $id. not found";
        }

        if(!task::deleteTaskByUserID($id)){
            return "Error during the suppresion of the tasks of the user";
        }

        $db = new Database();

        $stmt =  $db->pdo->prepare("DELETE FROM users WHERE id=:id");

        if ($stmt->execute([
            ":id" => $id,
        ])){
            return "202 : Success, user ".$id." deleted";
        } else {
            return "Error during the suppresion";
        }
    }

    public static function checkMailAdress($email){

        $db = new Database();

        $stmt =  $db->pdo->prepare("SELECT * FROM users WHERE email=:email");

        $stmt->execute([
            ":email" => $email,
        ]);

        return $stmt->fetchObject();
    }




}