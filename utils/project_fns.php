<?php 

/* 
  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  │ ⁡⁣⁢⁣​‌‌‌𝕡𝕣𝕠𝕛𝕖𝕔𝕥_𝕗𝕟𝕤.𝕡𝕙𝕡​⁡                                                                                          │
  ├─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┤
  │ A set of function to manipulate with projects. D͟o͟c͟u͟m͟e͟n͟t͟a͟t͟i͟o͟n b͟e͟l͟o͟w.                                     │
  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 */

 /**
  * File for manipulating with projects.
  * 
  * This file contains a class that manipulates with projects.
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

  /* -------------------------------------------------------------------------- */
  /*                                  Includes                                  */
  /* -------------------------------------------------------------------------- */
  include_once 'timer_fns.php';
  
/* -------------------------------------------------------------------------- */

/**
 * Creates a project
 * 
 * @param integer $userId  ID of the user
 * @param string  $name    Comment
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function createProject($userId, $name) {
    DB::query("INSERT INTO projects (name, user_id) VALUES (:name, :userId)", array(':name'=>$name, ':userId'=>$userId));
}

/**
 * Edits a project
 * 
 * @param integer $projectId  ID of the project
 * @param string  $name   Comment
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function editProject($projectId, $name) {
    DB::query("UPDATE projects SET name=:value WHERE id=:projectId", array(':value'=>$name, ':projectId'=>$projectId));
}

/**
 * Deletes a project
 * 
 * @param integer $projectId  ID of the project
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function deleteProject($projectId) {
    DB::query("DELETE FROM projects WHERE id=:projectId", array(':projectId'=>$projectId));
}

/**
 * Gets id of the project
 * 
 * @param integer $userId  ID of the user
 * @param string  $name    Comment
 * 
 * @return integer
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function getProject($userId, $name) {
    return DB::query("SELECT * FROM projects WHERE name=:name AND user_id=:userId", array(':name'=>$name, ':userId'=>$userId));
}