<?php

/**
 * File for dumping variables.
 * 
 * This file dumps all variables saved in GET, POST, SESSION or COOKIE.
 * 
 * PHP version 7.4.27
 * 
 * LICENSE: This source file is subject to version 3 of the GNU GPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/gpl-3.0.html.
 * 
 * @category   Debugging
 * @author     Adam Ondrejčák <adam.ondrejcak@gmail.com>
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
 * @version    prerelease-1.0
 * @since      File available since alpha-2.1.1
 */
session_start();

/**
 * Displays dump of variables
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function display_dump()
{
    echo "======================[ START OF VARDUMP ]======================<br><br>";
    echo "===========[ GET VARIABLES ]===========<br>";
    echo dump_array($_GET) . '<br><br>';
    echo "===========[ POST VARIABLES ]===========<br>";
    echo dump_array($_POST) . '<br><br>';
    echo "===========[ SESSION VARIABLES ]===========<br>";
    echo dump_array($_SESSION) . '<br><br>';
    echo "===========[ COOKIE VARIABLES ]===========<br>";
    echo dump_array($_COOKIE) . '<br><br>';
    echo "======================[ END OF VARDUMP ]======================";
}

/**
 * Displays dump of variables
 *
 * @param array $array Array to dump
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function dump_array($array)
{
    if (is_array($array)) {
        $size = count($array);
        $string = "";
        if ($size) {
            $count = 0;
            $string .= "{ ";
            foreach($array as $var => $value) {
                $string .= $var." = ".$value;
                if($count++ < ($size-1)) {
                    $string .= ", ";
                }
            }
            $string .= " }";    
        } else {
            $string = "<i>empty</i>";
        }
        return $string;
    } else {
        return $array;
    }
}

/* -------------------------------------------------------------------------- */
/*                                   Display                                  */
/* -------------------------------------------------------------------------- */
display_dump();