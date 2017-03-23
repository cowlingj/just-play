<?php 
  // display the broadcast form
  function read($path, $query, $db) {
    
    // an array or null containing the users broadcast
    $correspondingBroadcast = $db-> query("SELECT * FROM broadcast WHERE id = $_SESSION['userId']")->fetch_assoc();

    // the location of that broadcast
    $correspondingBroadcastQuery = $db-> query("SELECT * FROM location WHERE id = $correspondingBroadcast['location']")->fetch_assoc();
    if ($correspondingBroadcast["reciever"] != null) { // THIS MAY CAUSE A NULL POINTER IF THE USER IS CREATIONG A BROADCAST REQUEST
      $accepted = true;
    }
    require layout("broadcast");
  }

?>