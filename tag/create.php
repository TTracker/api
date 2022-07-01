<?php

require_once '../utils/DB.php';
require_once '../utils/token.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->name)) {
            http_response_code(400);
            die(json_encode(array('error' => 'Please fill out the name.')));
        }

        $token = Token::getFromHeaders();
        
        DB::query("INSERT INTO tags (name, user_id) VALUES (:name, :uid)", array(':name'=>htmlentities($data->name), ':uid'=>Token::getUserId($token)));

        echo json_encode(array('success'=>'Tag created'));
    }
} else {
    echo json_encode(array('error' => 'Access denied'));
    http_response_code(401);
}

//End of file