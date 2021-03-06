<?php

/* 
  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  │ ⁡⁣⁢⁣​‌‌‍𝕥𝕚𝕞𝕖𝕣_𝕗𝕟𝕤.𝕡𝕙𝕡​⁡                                                                                           │
  ├─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┤
  │ A set of functions capable of creating, editing and deleting timers.                                            │
  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 */

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
/* -------------------------------------------------------------------------- */
//// Deprecated: include 'exceptions.php';
include 'error_handler.php';
set_error_handler('error_handler');
/* -------------------------------------------------------------------------- */
include 'token_fns.php';

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
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function createTimer($id, $projectId, $userId, $comment)
{
    DB::query("INSERT INTO time (id, project_id, user_id, comment, time_started) VALUES (:id, :projectId, :userId, :comment, :timeStarted)", array(':id' => $id, ':projectId' => $projectId, ':userId' => $userId, ':comment' => $comment, ':timeStarted' => time()));
        // throw new TimerCreateException('Could not create the timer.');
        // die(trigger_error('Could not create the timer.', E_USER_ERROR));
    
}

/**
 * Edits a timer's comment
 * 
 * @param integer $id       ID of the timer
 * @param string  $comment  New Comment
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function editTimerComment($id, $comment)
{
    DB::query("UPDATE time SET comment = :value WHERE id=:id ORDER BY time_started DESC LIMIT 1", array(':value' => $comment, ':id' => $id));
}

/**
 * Edits a timer's tag
 * 
 * @param integer $id     ID of the timer
 * @param integer $tagId  New Tag
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function editTimerTag($id, $tagId)
{
    DB::query("UPDATE time SET tag_id = :tagId WHERE id=:id ORDER BY time_started DESC LIMIT 1", array(':tagId' => $tagId, ':id' => $id));
}

/**
 * Pauses a timer
 * 
 * @param integer $id  ID of the timer
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function pauseTimer($id)
{
    $timeStarted = DB::query("SELECT * FROM time WHERE id = :id ORDER BY time_started DESC LIMIT 1", array(':id' => $id))[0]['time_started'];
    DB::query("UPDATE time SET time_ended = :now, length = :diff WHERE id = :id ORDER BY time_started DESC LIMIT 1", array(':now' => time(), ':diff' => time() - $timeStarted, ':id' => $id));
}

/**
 * Resumes a timer
 * 
 * @param integer $id      ID of the timer
 * @param integer $userId  ID of the user
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function resumeTimer($id, $userId)
{
    $projectId = DB::query("SELECT * FROM time WHERE id=:id LIMIT 1", array(':id' => $id))[0]['project_id'];
    $tagId = DB::query("SELECT * FROM time WHERE id=:id ORDER BY time_started DESC LIMIT 1", array(':id' => $id))[0]['tag_id'];
    $comment = DB::query("SELECT * FROM time WHERE id=:id LIMIT 1", array(':id' => $id))[0]['comment'];
    DB::query("INSERT INTO time (id, user_id, project_id, tag_id, comment, time_started) VALUES (:id, :userId, :projectId, :tagId, :comment, :timeStarted)", array(':id' => $id, ':userId' => $userId, ':projectId' => $projectId, ':tagId'=>$tagId, ':comment' => $comment, ':timeStarted' => time()));
}
