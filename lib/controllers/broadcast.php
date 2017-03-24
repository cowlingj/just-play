<?php
  require_once("lib/helpers/auth.php");
  // display the broadcast form
  function read($path, $query, $db) {
    
    $currentUser = getCurrentUser();
    
    // retrieve reference to all sports in database
    $sports = $db->query("SELECT * FROM sport")->fetch_all();

    // an array or null containing the users broadcast
    $correspondingBroadcast = $db->query("SELECT * FROM broadcast WHERE id=".$currentUser['id'])->fetch_assoc();

    // the location of that broadcast
    // $correspondingBroadcastQuery = $db->query("SELECT * FROM location WHERE id=".$correspondingBroadcast['location'])->fetch_assoc();
    if ($correspondingBroadcast["reciever"] != null) { // THIS MAY CAUSE A NULL POINTER IF THE USER IS CREATIONG A BROADCAST REQUEST
      $accepted = true;
    }
    require layout("broadcast");
  }

?>