<?php



// request?broadcastID=&recieverID=
function destroy($path, $query, $db) {
  // the broadcast information from the query string
  $broadcastID = $query["broadcastID"];
  $recieverID = $query["recieverID"];

  // the broadcast information from the database
  $broadcastInfo = $db->query("SELECT * FROM broadcast WHERE id='$broadcastID'");

  // physically deleting the broadcast from the table
  $db->query("DELETE * FROM broadcast WHERE id='$broadcastID'");


  // creating the game from broadcast information
  $db->query("INSERT INTO game (sport, ");

  // redirect to whatever route you need
}




?>