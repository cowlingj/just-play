<?php
require_once("lib/helpers/auth.php");
function read($path, $query, $db) {

  if(isLoggedIn()) {
   $currentUser = getCurrentUser();
   print_r($currentUser);
   die("Killed by Melvin");

    // db query will have 0 or 1 row depending on whether or not the user has a broadcast request
    // if it has a row, that row will be the users broadcast request
    $correspondingBroadcast = $db->query("SELECT * FROM broadcast WHERE id = " . $currentUser['id']);

    // test whether the user has a broadcast request
    // if so view that request else view the search form
    if($correspondingBroadcast->num_rows() != 0) {
      $correspondingBroadcast = $correspondingBroadcast->fetch_assoc();
      require layout("view-broadcast");
    }
    else
      require layout("search-form");
  } else header("Location: /mbax4msk/just_play/");
}
?>
