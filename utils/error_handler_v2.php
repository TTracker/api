<?php

/* 
  ┌─────────────────────────────────────────────────────────────────────────┐
  │ ⁡⁢⁣⁢​‌‌‍​‌‌‌𝔼𝕣𝕣𝕠𝕣 ℍ𝕒𝕟𝕕𝕝𝕖𝕣 𝘃𝟮​​⁡                                       │
  ├─────────────────────────────────────────────────────────────────────────┤
  │ Simpler and better error handler for custom errors                      │
  └─────────────────────────────────────────────────────────────────────────┘
 */

function handle_error($message)
{
  /* 
    ┌─────────────────────────────────────────────────────────────────────────────┐
    │ ⁡⁢⁣⁣​‌‍‌​‌‌‍404 Errors​​⁡                                                             │
    ├─────────────────────────────────────────────────────────────────────────────┤
    │ Errors when something is not found or something is non-existent             │
    └─────────────────────────────────────────────────────────────────────────────┘
  */

    if (strpos($message, 'does not exist') !== false || strpos($message, 'not found') !== false) {
        echo json_encode(array('error'=>$message, 'severity'=>'fatal'));
        http_response_code(404);
    } 
    
  /* 
    ┌─────────────────────────────────────────────────────────────────────────────┐
    │ ⁡⁢⁣⁣​‌‍‌​‌‌‍401 Errors​​⁡                                                             │
    ├─────────────────────────────────────────────────────────────────────────────┤
    │ Errors when someone doesn't have access                                     │
    └─────────────────────────────────────────────────────────────────────────────┘
  */
    else if (strpos($message, 'Access denied') !== false) {
        echo json_encode(array('error'=>$message, 'severity'=>'fatal'));
        http_response_code(401);
    } 
    
    /* 
    ┌─────────────────────────────────────────────────────────────────────────────┐
    │ ⁡⁢⁣⁣‌‍‌​‌‌‍400 Errors​​⁡                                                             │
    ├─────────────────────────────────────────────────────────────────────────────┤
    │ Errors when something is not filled out correctly                           │
    └─────────────────────────────────────────────────────────────────────────────┘
  */
    else if (strpos($message, 'fill out') !== false) {
        echo json_encode(array('error'=>$message, 'severity'=>'high'));
        http_response_code(400);
    }

    // TODO: More errors
}
