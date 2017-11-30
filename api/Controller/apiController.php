<?php

/**
 * Created by PhpStorm.
 * User: Adrien
 */

require_once(__ROOT__ . '/config/config.php');
require_once(__ROOT__ . '/model/api.php');
require_once(__ROOT__ . '/model/database.php');
require_once(__ROOT__ . '/model/user.php');
require_once(__ROOT__ . '/model/task.php');


class apiController extends api
{
    public function __construct() {
        parent::__construct();

    }

    //user/*
    //endpoint of user, redirect to the correct function to use
    protected function user($params = null, $action = null) {

        if ($this->request_method == 'GET') {

            if ($params == null){
                $result = user::getAllUsers();

            } else {
                $result = user::getUserByID($params[0]);
                if ($result == false){
                    return "Wrong user ID";
                }
            }

            return $result;

        } else if ($this->request_method == 'POST') {
            if ($action == 'add'){
                $result = user::addUser($this->request);

            } else {
                return "Wrong endpoints";
            }
            return $result;

        } else if ($this->request_method == 'DELETE'){

            if ($params != null && $action == "delete" ) {
                return $result = user::deleteUser($params[0]);
            }
        }
    }

    //task/*
    //Endpoint of task, redirect to the correct function to use
    protected function task($params = null, $action = null){

        if ($this->request_method == 'GET') {

            if ($params != null && $action == null ){

                $result = task::getTaskByID($params[0]);

            }else if ($params != null && $action == "user" ) {

                $result = task::getTaskByUserID($params[0], $action);

            } else if ($params == null && $action == null ) {
                $result = task::getAllTasks();

            } else {
                return "Wrong endpoints";
            }
            return $result;


        } else if ($this->request_method == 'POST') {

            if ($action == 'create'){

                $result = task::addTask($this->request);

            } else {
                return "Wrong endpoints";
            }
            return $result;

        } else if ($this->request_method == 'DELETE'){

            if ($params != null && $action == "delete" ) {
                return $result = task::deleteTaskById($params[0]);
            }
        }

    }

}