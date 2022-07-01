<?php

require_once '../utils/timer_fns.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if (Token::check($token = Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->timerId)) {
            http_response_code(400);
            die(trigger_error('Please fill out the timerId', E_USER_WARNING));
        }
        if (DB::query("SELECT * FROM time WHERE id=:timerId AND user_id=:userId LIMIT 1", array(':timerId'=>htmlspecialchars($data->timerId), ':userId'=>Token::getUserId($token))) != null) {
            if (DB::query("SELECT * FROM time WHERE id = :timerId ORDER BY time_started DESC LIMIT 1", array(':timerId' => htmlspecialchars($data->timerId)))[0]['time_ended'] == null) {
                pauseTimer((int) htmlspecialchars($data->timerId));

                echo json_encode(array('success' => 'Timer has been paused!'));
            } else {
                trigger_error('Timer is already paused', E_USER_NOTICE);
                http_response_code(418);
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