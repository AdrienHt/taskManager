<?php

/**
 * Created by PhpStorm.
 * User: Adrien
 */

// This class is the model for the API class

Abstract class api
{
    //All the request
    protected $request;

    //Type of the request (PUT, GET, POST, DELETE)
    protected $request_method = '';

    //Endpoint from params URL (/user...)
    protected $endpoint = '';

    //Type of the func that we have to execute (user/get)
    protected $action = null;

    //Parameters in the URL (user/get/1)
    protected $params = array();

    protected $file = null;

    //Data to set header
    protected $content_type = "application/json";


    public function __construct() {

        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");


        $this->request_method = $_SERVER['REQUEST_METHOD'];

        $this->analayseAndCleanImputs();


        //get the request and clean it
        $this->params = explode('/', strtolower(rtrim($_REQUEST['request'], '/')));
        $this->params = $this->cleanInputs($this->params);

        //get first element of the request
        $this->endpoint = strtolower(array_shift($this->params));

        //get all that is in params and that is not a number
        if (array_key_exists(0, $this->params) && !is_numeric($this->params[0])) {
            $this->action = array_shift($this->params);
        }

    }

    private function analayseAndCleanImputs(){

        switch($this->request_method) {
            case 'DELETE':
                $this->request = $this->cleanInputs($_GET);
            case 'POST':
                $this->request = $this->cleanInputs($_POST);
                break;
            case 'GET':
                $this->request = $this->cleanInputs($_GET);
                break;
            case 'PUT':
                parse_str(file_get_contents("php://input"), $this->request);
                $this->request = $this->cleanInputs($this->request);
                break;
            default:
                $this->result('Invalid Method', 405);
                break;
        }
    }


    //Remove Html,php and /
    private function cleanInputs($data){
        $clean_input = array();
        //if it's a tab we clean all the values
        if(is_array($data)){
            foreach($data as $k => $v){
                $clean_input[$k] = $this->cleanInputs($v);
            }
        }else{
            //If it's a value, we clean the value
            $data = trim(stripslashes($data));
            $data = strip_tags($data);
            $clean_input = trim($data);
        }
        return $clean_input;
    }


    public function processAPI() {

        //Check if method called exist
        if (method_exists($this, $this->endpoint)) {
            if ($this->action != null){
                return $this->result($this->{$this->endpoint}($this->params, $this->action));
            }
            return $this->result($this->{$this->endpoint}($this->params));
        }
        //If doen't exit : error 404
        return $this->result("No Endpoint: $this->endpoint", 404);
    }

    private function getStatusMessage($code) {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }

    private function result($result, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->getStatusMessage($status));
        echo json_encode($result);
    }

}