<?php

require_once '../utils/DB.php';
require_once '../utils/token.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->tid) || !(isset($data->comment) || isset($data->tagid))) {
            http_response_code(400);
            die(json_encode(array('error' => 'Please fill out the timerId and comment or tagid.')));
        }

        $token = Token::getFromHeaders();
        if (DB::query("SELECT * FROM time WHERE id=:tid AND user_id=:uid LIMIT 1", array(':tid'=>htmlentities($data->tid), ':uid'=>Token::getUserId(Token::getFromHeaders()))) != null) {
            // // if (DB::query("SELECT * FROM time WHERE id = :tid ORDER BY time_started DESC LIMIT 1", array(':tid' => htmlentities($data->tid)))[0]['time_ended'] == null) {
            // //     $ts = DB::query("SELECT * FROM time WHERE id = :tid ORDER BY time_started DESC LIMIT 1", array(':tid' => htmlentities($data->tid)))[0]['time_started'];
            // //     DB::query("UPDATE time SET time_ended = :now, length = :diff WHERE id = :tid ORDER BY time_started DESC LIMIT 1", array(':now' => time(), ':diff' => time() - $ts, ':tid' => htmlentities($data->tid)));

            // //     // echo $new_len;
            // //     // DB::query("UPDATE time SET length = :len, paused? = :pause WHERE id = :tid", array(':len' => $new_len, ':pause'=> '1', ':tid' => htmlentities($data->tid)));
            // //     // DB::query("UPDATE time SET paused? = 1 WHERE id = :tid", array(':tid' => htmlentities($data->tid)));

            // //     echo json_encode(array('success' => 'Timer has been paused!'));
            // // } else {
            // //     echo json_encode(array('error' => 'Timer is already paused'));
            // //     http_response_code(418);
            // // }

            // if(DB::query("SELECT * FROM time WHERE id = :tid ORDER BY time_started DESC LIMIT 1", array(':tid' => htmlentities($data->tid)))[0]['time_ended'] != null) {
            //     $pid = DB::query("SELECT * FROM time WHERE id=:tid LIMIT 1", array(':tid' => htmlentities($data->tid)))[0]['project_id'];
            //     $cmt = DB::query("SELECT * FROM time WHERE id=:tid LIMIT 1", array(':tid' => htmlentities($data->tid)))[0]['comment'];
            //     DB::query("INSERT INTO time (id, user_id, project_id, comment, time_started) VALUES (:tid, :uid, :pid, :comment, :timeS)", array(':tid'=>htmlentities($data->tid),':uid'=>Token::getUserId($token), ':pid'=>$pid, ':comment'=>$cmt, ':timeS'=>time()));
            //     echo json_encode(array('success' => 'Timer resumed'));
            // } else {
            //     echo json_encode(array('error' => 'Timer already running'));
            //     http_response_code(418);
            // }

            if(isset($data->comment)) {
                // $rows = DB::query("SELECT comment WHERE id=:tid", array(':tid' => htmlentities($data->tid)));
                // for($row in $rows) {

                // }
                DB::query("UPDATE time SET comment = :value WHERE id=:tid ORDER BY time_started DESC LIMIT 1", array(':value'=>htmlentities($data->comment),':tid'=> htmlentities($data->tid)));
                echo json_encode(array('success'=>'Edited the comment.'));
            }
            if(isset($data->tagid)) {
                // $rows = DB::query("SELECT comment WHERE id=:tid", array(':tid' => htmlentities($data->tid)));
                // for($row in $rows) {

                // }
                DB::query("UPDATE time SET tag_id = :value WHERE id=:tid ORDER BY time_started DESC LIMIT 1", array(':value'=>htmlentities($data->tagid),':tid'=> htmlentities($data->tid)));
                echo json_encode(array('success'=>'Edited the tagId.'));
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