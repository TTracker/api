<?php

require_once '../utils/timer_fns.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->comment)) {
            http_response_code(400);
            die(trigger_error('Please enter the comment', E_USER_WARNING));
        }

        $token = Token::getFromHeaders();

        @$last_tid = DB::query("SELECT * FROM time ORDER BY id DESC LIMIT 1")[0]['id'];
        @$new_tid = $last_tid + 1;

        createTimer($new_tid, isset($data->projectId) ? htmlspecialchars($data->projectId) : NULL, Token::getUserId($token), htmlspecialchars($data->comment));

        echo json_encode(array('success' => 'Timer has been created!'));
    }
} else {
    trigger_error('Access denied', E_USER_WARNING);
    http_response_code(401);
}

//End of file