<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 25/11/2017
 * Time: 11:25
 */

define('__ROOT__', dirname(dirname(__FILE__)).'/api');

require_once(__ROOT__ . '/Controller/apiController.php');


try {

    $API = new apiController();
    $API->processAPI();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}