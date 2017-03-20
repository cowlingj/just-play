<?php 
  // display the broadcast form
  function read($path, $query, $db) {
    
    $correspondingBroadcast = $db-> query('SELECT * FROM broadcasts WHERE id = $_SESSION["userId"]')->fetch_assoc();

    require layout("broadcast-request-form");
  }

?>