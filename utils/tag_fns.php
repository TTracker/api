<?php 

/* 
  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  │ ⁡⁣⁢⁣​‌‌‌𝕥𝕒𝕘_𝕗𝕟𝕤.𝕡𝕙𝕡​⁡                                                                                          │
  ├─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┤
  │ A set of function to manipulate with tags. D͟o͟c͟u͟m͟e͟n͟t͟a͟t͟i͟o͟n b͟e͟l͟o͟w.                                     │
  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
 */

 /**
  * File for manipulating with tags.
  * 
  * This file contains a class that manipulates with tags.
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
 * Creates a tag
 * 
 * @param integer $userId  ID of the user
 * @param string  $name    Comment
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function createTag($userId, $name) {
    DB::query("INSERT INTO tags (name, user_id) VALUES (:name, :userId)", array(':name'=>$name, ':userId'=>$userId));
}

/**
 * Edits a tag
 * 
 * @param integer $tagId  ID of the tag
 * @param string  $name   Comment
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function editTag($tagId, $name) {
    DB::query("UPDATE tags SET name=:value WHERE id=:tagId", array(':value'=>$name, ':tagId'=>$tagId));
}

/**
 * Deletes a tag
 * 
 * @param integer $tagId  ID of the tag
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function deleteTag($tagId) {
    DB::query("DELETE FROM tags WHERE id=:tagId", array(':tagId'=>$tagId));
}

/**
 * Gets id of the tag
 * 
 * @param integer $userId  ID of the user
 * @param string  $name    Comment
 * 
 * @return integer
 * 
 * @author Adam Ondrejčák <adam.ondrejcak@gmail.com>
 */
function getTag($userId, $name) {
    return DB::query("SELECT * FROM tags WHERE name=:name AND user_id=:userId", array(':name'=>$name, ':userId'=>$userId));
}