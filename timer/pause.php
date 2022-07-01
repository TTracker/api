<?php

require_once '../utils/DB.php';
require_once '../utils/token.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->tid)) {
            http_response_code(400);
            die(json_encode(array('error' => 'Please fill out the timerId.')));
        }

        $token = Token::getFromHeaders();
        if (DB::query("SELECT * FROM time WHERE id=:tid AND user_id=:uid LIMIT 1", array(':tid'=>htmlentities($data->tid), ':uid'=>Token::getUserId(Token::getFromHeaders()))) != null) {
            if (DB::query("SELECT * FROM time WHERE id = :tid ORDER BY time_started DESC LIMIT 1", array(':tid' => htmlentities($data->tid)))[0]['time_ended'] == null) {
                $ts = DB::query("SELECT * FROM time WHERE id = :tid ORDER BY time_started DESC LIMIT 1", array(':tid' => htmlentities($data->tid)))[0]['time_started'];
                DB::query("UPDATE time SET time_ended = :now, length = :diff WHERE id = :tid ORDER BY time_started DESC LIMIT 1", array(':now' => time(), ':diff' => time() - $ts, ':tid' => htmlentities($data->tid)));

                // echo $new_len;
                // DB::query("UPDATE time SET length = :len, paused? = :pause WHERE id = :tid", array(':len' => $new_len, ':pause'=> '1', ':tid' => htmlentities($data->tid)));
                // DB::query("UPDATE time SET paused? = 1 WHERE id = :tid", array(':tid' => htmlentities($data->tid)));

                echo json_encode(array('success' => 'Timer has been paused!'));
            } else {
                echo json_encode(array('error' => 'Timer is already paused'));
                http_response_code(418);
            }
        } else {
            echo json_encode(array('error' => 'Timer does not exist'));
            http_response_code(404);
        }

        // DB::query("INSERT INTO time (user_id, project_id, comment, time_started) VALUES (:uid, :pid, :comment, :timeS)", array(':uid'=>Token::getUserId($token), ':pid'=>htmlentities($data->pid), ':comment'=>htmlentities($data->comment), ':timeS'=>htmlentities($data->timeStarted)));
        // DB::query("UPDATE time SET time ");
    }
} else {
    echo json_encode(array('error' => 'Access denied'));
    http_response_code(401);
}

//End of file