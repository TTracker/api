<?php

require_once '../utils/DB.php';
require_once '../utils/token.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->comment)) {
            http_response_code(400);
            die(json_encode(array('error' => 'Please fill out both the comment, projectId.')));
        }

        $token = Token::getFromHeaders();
    
        @$last_tid = DB::query("SELECT * FROM time ORDER BY id DESC LIMIT 1")[0]['id'];
        @$new_tid = $last_tid + 1;

        DB::query("INSERT INTO time (id, project_id, user_id, comment, time_started) VALUES (:tid, :pid, :uid, :comment, :timeS)", array(':tid'=>$new_tid, ':pid'=>htmlentities($data->pid), ':uid'=>Token::getUserId($token), ':comment'=>htmlentities($data->comment), ':timeS'=>time()));

    
        echo json_encode(array('success' => 'Timer has been created!'));
    }
} else {
    echo json_encode(array('error' => 'Access denied'));
    http_response_code(401);
}

//End of file