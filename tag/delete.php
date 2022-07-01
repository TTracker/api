<?php

require_once '../utils/DB.php';
require_once '../utils/token.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->tagid)) {
            http_response_code(400);
            die(json_encode(array('error' => 'Please fill out the tagId.')));
        }

        $token = Token::getFromHeaders();
        
        DB::query("DELETE FROM tags WHERE id=:tagid", array(':tagid'=>htmlentities($data->tagid)));

        echo json_encode(array('success'=>'Tag deleted'));
    }
} else {
    echo json_encode(array('error' => 'Access denied'));
    http_response_code(401);
}

//End of file