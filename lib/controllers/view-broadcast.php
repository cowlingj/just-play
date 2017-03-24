<?php
require_once("lib/helpers/auth.php");
require_once("database-functions.php");
function read($path, $query, $db) {
  //$correspondingBroadcast["sport"];
  //$correspondingBroadcast["location"];
  
  $userID = getCurrentUser();
  //checkUserState($userID);

  $broadcastInfo = $db->query("SELECT * FROM broadcast WHERE broadcaster='$userID'");

  if ($broadcastInfo ==false || $broadcastInfo->num_rows== 0 ){
    die("Death on view-broadcast this shouldn't happen.(user should've been redirected.)");
  }

  $broadcastInfo=$broadcastInfo->fetch_assoc();
  //Assume sportID and locationID are correct

  $sportID   = $broadcastInfo["sport"];
  $locationID= $broadcastInfo["location"];

  $result = $db->query("SELECT * FROM location WHERE id=$locationID");
  $correspondingBroadcast["location"]=$result["name"];

  $result = $db->query("SELECT * FROM sport WHERE id=$sportID");
  $correspondingBroadcast["sport"]=$result["name"];

  require layout('view-broadcast');
}

?>