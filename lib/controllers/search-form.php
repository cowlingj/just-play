<?php
function read($path, $query, $db) {

  // db query will have 0 or 1 row depending on whether or not the user has a broadcast request
  // if it has a row, that row will be the users broadcast request
  $correspondingBroadcast = $db-> query("SELECT * FROM broadcast WHERE id = $_SESSION['userId']");

  // test whether the user has a broadcast request
  // if so view that request else view the search form
  if($correspondingBroadcast->num_rows() != 0) {
    $correspondingBroadcast = $correspondingBroadcast->fetch_assoc();
    require layout("view-broadcast");
  }
  else
    require layout("search-form");
}
?>