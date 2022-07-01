<?php
require_once "DB.php";
class Token
{
    public static function create($id)
    {
        $token = rand(10000000000000000, 99999999999999999);
        DB::query("INSERT INTO sessions (uid, token, logged_at) VALUES (:uid, :token, :time)", array(':uid' => $id, ':token' => $token, ':time' => time()));
        return $token;
    }

    public static function check($token)
    {
        $at = DB::query("SELECT * FROM sessions WHERE token=:token", array(':token' => $token))[0]['logged_at'];
        $now = time();
        $exp = $at + DB::query("SELECT * FROM config")[0]['token_exp'];
        if ($now >= $exp) {
            self::delete($token);
            return false;
        } else {
            return DB::query("SELECT * FROM sessions WHERE token=:token", array(':token' => $token))[0]['uid'];
        }
    }

    public static function getFromHeaders()
    {
        $headers = null;

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } else if (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }

            // HEADER: Get the access token from the header
            if (!empty($headers)) {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                    return $matches[1];
                }
            }
            return null;
        }
    }

    public static function getUserId($token) {
        return DB::query("SELECT * FROM sessions WHERE token=:token", array(':token'=>$token))[0]['uid'];
    }

    public static function getUsername($token) {
        return DB::query("SELECT * FROM users WHERE id=:uid", array(':uid'=>self::getUserId($token)));
    }

    public static function delete($token)
    {
        DB::query("DELETE FROM sessions WHERE token=:token", array(':token' => $token));
    }
}
