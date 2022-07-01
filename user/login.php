<?php

require_once '../utils/timer_fns.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // get posted data
    $data = json_decode(file_get_contents("php://input", true));

    if (!isset($data->username) || !isset($data->password)) {
        http_response_code(400);
        die(json_encode(array('error' => 'Please fill out both the name and password.')));
    }

    $hashed_pwd = DB::query("SELECT * FROM users WHERE username = :username", array(':username'=>htmlentities($data->username)))[0]['password'];
    
    if (!password_verify($data->password, $hashed_pwd)) {
        echo json_encode(array('error' => 'Invalid User'));
    } else {
        // $row = dbFetchAssoc($result);
        
        // $username = $row['username'];
        
        // $headers = array('alg'=>'HS256','typ'=>'JWT');
        // $payload = array('username'=>$username, 'exp'=>(time() + 600));

        // $jwt = generate_jwt($headers, $payload);
        
        // echo json_encode(array('token' => $jwt));

        $uid = DB::query('SELECT * FROM users WHERE username=:username', array(':username'=>htmlentities($data->username)))[0]['id'];

        $token = Token::create($uid);

        echo json_encode(array('token' => $token));
    }
}

//End of file