<?php

require_once '../utils/timer_fns.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");

if (Token::check($token = Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->timerId) || !(isset($data->comment) || isset($data->tagId))) {
            http_response_code(400);
            die(trigger_error('Please fill out the timerId and comment or tagId', E_USER_WARNING));
        }
        if (DB::query("SELECT * FROM time WHERE id=:timerId AND user_id=:userId LIMIT 1", array(':timerId' => htmlspecialchars($data->timerId), ':userId' => Token::getUserId($token))) != null) {
            if (isset($data->comment)) {
                editTimerComment(htmlspecialchars($data->timerId), htmlspecialchars($data->comment));
                echo json_encode(array('success' => 'Edited the comment.'));
            }
            if (isset($data->tagId)) {
                editTimerTag(htmlspecialchars($data->timerId), htmlspecialchars($data->tagId));
                echo json_encode(array('success' => 'Edited the tagId.'));
            }
        } else {
            trigger_error('Timer does not exist', E_USER_WARNING);
            http_response_code(404);
        }
    }
} else {
    trigger_error('Access denied', E_USER_WARNING);
    http_response_code(401);
}

//End of file