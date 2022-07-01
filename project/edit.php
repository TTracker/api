<?php

require_once '../utils/DB.php';
require_once '../utils/token.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->pid) || !isset($data->name)) {
            http_response_code(400);
            die(json_encode(array('error' => 'Please fill out the projectId and name.')));
        }

        $token = Token::getFromHeaders();
        
        DB::query("UPDATE projects SET name=:value WHERE id=:pid", array(':value'=>htmlentities($data->name), ':pid'=>htmlentities($data->pid)));

        echo json_encode(array('success'=>'Project edited'));
    }
} else {
    echo json_encode(array('error' => 'Access denied'));
    http_response_code(401);
}

//End of file