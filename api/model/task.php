<?php

/**
 * Created by PhpStorm.
 * User: Adrien
 */
class task
{
    private $con;
    private $table_name = "tasks";

    private $id;
    private $user_id;
    private $title;
    private $description;
    private $creation_date;
    private $status;

    /**
     * task constructor.
     * @param $id
     * @param $user_id
     * @param $title
     * @param $description
     * @param $creation_date
     * @param $status
     */

    public function __construct($id = null , $user_id, $title, $description, $creation_date, $status)
    {
       if ($id!=null){
           $this->id = $id;
       }
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->creation_date = $creation_date;
        $this->status = $status;
    }

    //task/user/id
    public static function getTaskByUserID($userID){

        $db = new Database();

        $stmt =  $db->pdo->prepare("SELECT * FROM tasks WHERE user_id=:userID");

        $stmt->execute([
            ":userID" => $userID,
        ]);

        //Close connection??

        $tasksArray = array();
        $tasksArray['tasks'] = array();

        if ($stmt->rowCount()>0){
            while ($row = $stmt->fetchALL(PDO::FETCH_ASSOC)){
                foreach ($row as $r){
                    $task = array(
                        "id" => $r['id'],
                        "user_id" => $r['user_id'],
                        "title" => $r['title'],
                        "description" => $r['description'],
                        "creation_date" => $r['creation_date'],
                        "status" => $r['status']
                    );
                    array_push( $tasksArray['tasks'], $task);
                }
            }
            return $tasksArray;
        } else {
            if (user::getUserByID($userID)){
                return "No task for this user";
            } else {
                return "User doesn't exist";
            }
        }

    }

    //task/id
    public static function getTaskByID($id){
        $db = new Database();

        $stmt =  $db->pdo->prepare("SELECT * FROM tasks WHERE id=:id");

        $stmt->execute([
            ":id" => $id,
        ]);

        $result = $stmt->fetchObject();

        if (!$result){
            return "Error, task not found";
        }
        return $result;


    }

    //task
    public static function getAllTasks(){

        $db = new Database();

        $stmt =  $db->pdo->prepare("SELECT * FROM tasks");

        $stmt->execute();

        //Close connection
        $tasksArray = array();
        $tasksArray['tasks'] = array();

        if ($stmt->rowCount()>0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                //$user = new user($row['id'], $row['name'], $row['email']);
                $task = array(
                    "id" => $row['id'],
                    "user_id" => $row['user_id'],
                    "title" => $row['title'],
                    "description" => $row['description'],
                    "creation_date" => $row['creation_date'],
                    "status" => $row['status']
                );
                array_push( $tasksArray['tasks'], $task);
            }
        }
        return $tasksArray;
    }

    //task/create
    public static function addTask($data){

        if (empty($data)){
            return "Nothing was send";
        }

        $errors = [];

        if (empty($data['user_id']) || !user::getUserByID($data['user_id'])) {
            $errors['user_id'] = "Error: User doesn't exist";
        }
        if (empty($data['title'])) {
            $errors['title'] = "Error: Title is not valid";
        }
        if (empty($data['description'])) {
            $errors['description'] =  "Error: Description not valid";
        }
        if (empty($data['creation_date']) || !self::validateDate($data['creation_date'])) {
            $errors['creation_date'] = "Error: The format should be YYYY-MM-dd";
        }
        if (empty($data['status'])) {
            $errors['status'] = "Error: status not valid";
        }

        if (!empty($errors)){
            return $errors;
        }

        //$task = new task(null, $data['user_id'], $data['title'], $data['description'], $data['creation_date'], $data['status']);

        $db = new Database();
        $stmt =  $db->pdo->prepare("INSERT INTO tasks(user_id, title, description, creation_date, status) VALUES (:user_id, :title, :description, :creation_date, :status)");

        if ($stmt->execute(array(
            "user_id" => $data['user_id'],
            "title" => $data['title'],
            "description" => $data['description'],
            "creation_date" => $data['creation_date'],
            "status" => $data['status']
            ))){
            return "202 : Success";
        } else {
            return "Error during the insertion";
        }

    }

    //task/delete/id
    public static function deleteTaskById($id){

        if (!self::getTaskByID($id)){
            return "404: Task not found";
        }

        $db = new Database();
        $stmt =  $db->pdo->prepare("DELETE FROM tasks WHERE id=:id");
        if ($stmt->execute([
            ":id" => $id,
        ])){
            return "202 : Success, task ".$id." deleted";
        } else {
            return "Error during the suppresion";
        }

    }

    public static function deleteTaskByUserID($user_id){

        if (!self::getTaskByUserID($user_id)){
            return "404: User . $user_id. not found";
        }

        $db = new Database();
        $stmt =  $db->pdo->prepare("DELETE FROM tasks WHERE user_id=:user_id");
        if ($stmt->execute([
            ":user_id" => $user_id,
        ])){
            return true;
        } else {
            return false;
        }

    }


    public static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


}