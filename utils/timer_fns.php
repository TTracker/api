<?php 
 /**
  * File for connecting utilities and functions for timers.
  * 
  * This file contains functions for creating or editing or deleting timers.
  * 
  * PHP version 7.4.27
  * 
  * LICENSE: This source file is subject to version 3 of the GNU GPL license
  * that is available through the world-wide-web at the following URI:
  * http://www.gnu.org/licenses/gpl-3.0.html.
  * 
  * @category   Timers
  * @author     Adam Ondrejčák <adam.ondrejcak@gmail.com>
  * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU GPL v3
  * @version    prerelease-1.0
  * @since      File available since alpha-2.1.0
  */

  include 'db_fns.php';
  include 'exceptions.php';
  include 'token_fns';

 /* -------------------------------------------------------------------------- */
 /*                                  Functions                                 */
 /* -------------------------------------------------------------------------- */

 /**
  * Creates a timer
  * 
  * @param integer $id         ID of the timer
  * @param integer $projectId  ID of a project (can be NULL)
  * @param integer $userId     ID of the user
  * @param string  $comment    Comment of the timer
  * 
  * @throws TimerCreateException
  * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
  */
 function createTimer($id, $projectId, $userId, $comment) {
    if (!DB::query("INSERT INTO time (id, project_id, user_id, comment, time_started) VALUES (:id, :projectId, :userId, :comment, :timeStarted)", array(':id'=>$id, ':projectId'=>$projectId, ':userId'=>$userId, ':comment'=>$comment, ':timeStarted'=>time()))) {
        throw new TimerCreateException('Could not create the timer.');
    }
 }
?>