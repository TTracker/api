<?php
 /**
  * File for Error Handler.
  * 
  * This file contains a handler that handles error occurred while executing tracker functions.
  * 
  * PHP version 7.4.27
  * 
  * LICENSE: This source file is subject to version 3 of the GNU GPL license
  * that is available through the world-wide-web at the following URI:
  * http://www.gnu.org/licenses/gpl-3.0.html.
  * 
  * @category   Errors
  * @author     Adam Ondrejčák <adam.ondrejcak@gmail.com>
  * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
  * @version    prerelease-1.0
  * @since      File available since alpha-2.1.1
  */

  /**
   * The Error Handler
   * 
   * @param string $etype  Type of the error
   * @param string $emsg   Error message
   * @param string $efile  File where the error occurred
   * @param string $eline  Line where the error occurred
   * 
   * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
   */
  function error_handler($etype, $emsg, $efile, $eline) {

/* 
  ┌─────────────────────────────────────────────────────────────────────────────┐
  │ ⁡⁣⁢⁢​‌‍‌⁡⁣⁣⁢ℍ𝕒𝕟𝕕𝕝𝕚𝕟𝕘 𝕖𝕣𝕣𝕠𝕣𝕤​⁡⁡                                                             │
  └─────────────────────────────────────────────────────────────────────────────┘
 */

    echo '<strong>An error occurred while trying to execute a command.</strong><br>';
    echo 'Details:';
    echo '<ul><li>Message: <i>'. $emsg .'</i></li>';
    echo '<li>File: <i>'. $efile .'</i></li>';
    echo '<li>Line: <i>'. $eline .'</i></li>';
    if(($etype == E_USER_ERROR) || ($etype == E_ERROR)) {
        echo '<li>Severity: <i><strong>Fatal</strong></i></li>';
        echo 'The program will now stop.';
    } else if (($etype == E_USER_WARNING) || ($etype == E_WARNING)) {
        echo '<li>Severity: <i>Medium</i></li>';
    } else if (($etype == E_USER_NOTICE) || ($etype == E_NOTICE)) {
        echo '<li>Severity: <i>Low</i></li>';
    }
    echo '</ul>';
    echo 'Please contact site administrators.';
    echo '<hr>';
  }

/* 
  ┌─────────────────────────────────────────────────────────────────────────┐
  │ ‍​‌‌‍⁡⁣⁢⁣𝕋𝕖𝕤𝕥𝕚𝕟𝕘 𝕥𝕙𝕖 𝕙𝕒𝕟𝕕𝕝𝕖𝕣​⁡                                           │
  ├─────────────────────────────────────────────────────────────────────────┤
  │ Uncomment lines with ⁡⁢⁢⁢#⁡ on the beginning to test ⁡                        │
  └─────────────────────────────────────────────────────────────────────────┘

  #   set_error_handler('error_handler');

  #   trigger_error('trigger_error() called', E_USER_NOTICE);
  #   fopen('nonexistentfile', 'r');
  #   trigger_error('trigger_error() called', E_USER_WARNING);
  #   include('nonexistentfile');
  #   trigger_error('trigger_error() called', E_USER_ERROR);