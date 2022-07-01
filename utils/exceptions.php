<?php 
 /**
  * File for custom exceptions.
  * 
  * This file contains exception classes for various scenarios like TimerCreateException.
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
  * @since      File available since alpha-2.1.0
  * @deprecated File deprecated since alpha-2.1.1
  */

 
 /**
  * Throws when creating a timer fails.
  * 
  * If an error occurs when trying to insert a timer to a database, 
  * argument check fails or the token is invalid the code will throw
  * this error.
  *
  * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
  * @version    prerelease-1.0
  * @since      Class available since alpha-2.1.0
  * @deprecated Class deprecated since alpha-2.1.1
  */
 class TimerCreateException extends Exception {
    function __toString() {
        return "<strong>Failed creating a timer:</strong> " . $this->getMessage() . " in " . $this->getFile() . " on line " . $this->getLine() . " (" . $this->getCode() . ")";
    }
 } 
?>