<?php 

/* 
  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  │ ⁡⁣⁢⁣​‌‌‌𝕕𝕓_𝕗𝕟𝕤.𝕡𝕙𝕡​⁡                                                                                          │
  ├─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┤
  │ A class that connects to the 𝗱𝗮𝘁𝗮𝗯𝗮𝘀𝗲 and makes 𝗾𝘂𝗲𝗿𝗶𝗲𝘀. D͟o͟c͟u͟m͟e͟n͟t͟a͟t͟i͟o͟n b͟e͟l͟o͟w.                                     │
  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 */

 /**
  * File for database class.
  * 
  * This file contains a class that connects to the database and makes queries.
  * 
  * PHP version 7.4.27
  * 
  * LICENSE: This source file is subject to version 3 of the GNU GPL license
  * that is available through the world-wide-web at the following URI:
  * http://www.gnu.org/licenses/gpl-3.0.html.
  * 
  * @category   Database
  * @author     Adam Ondrejčák <adam.ondrejcak@gmail.com>
  * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
  * @version    prerelease-1.0
  * @since      File available since alpha-2.1.1
  */
  
/**
 * Database class
 *
 * A class that connects to the database and makes queries.
 * 
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
 * @version    prerelease-1.0
 * @since      Class available since alpha-2.1.1
 */ 
class DB {
    // ​‌‍‌⁡⁣⁣⁢⁡⁢⁣⁣𝔻𝔹::𝕔𝕠𝕟𝕟𝕖𝕔𝕥()⁡​⁡
    private static function connect() {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=timetracker;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    // ⁡⁣⁣⁢​‌‍‌𝔻𝔹::𝕢𝕦𝕖𝕣𝕪($𝕢𝕦𝕖𝕣𝕪, $𝕡𝕒𝕣𝕒𝕞𝕤)​⁡
    public static function query($query, $params = array()) {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);

        if(explode(' ', $query)[0] == 'SELECT') {
            $data = $stmt->fetchAll();
            return $data;
        }
    }
}