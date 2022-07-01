<?php

require_once '../utils/DB.php';
require_once '../utils/token.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

@$tokenValid = Token::check(Token::getFromHeaders());

if ($tokenValid) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        $token = Token::getFromHeaders();

        Token::delete($token);

        echo json_encode(array('success' => 'Logged out.'));

    } else {
        echo json_encode(array('error' => 'Method not Supported'));
        http_response_code(405);
    }
} else {
    echo json_encode(array('error' => 'Access denied'));
    http_response_code(401);
}

//End of file