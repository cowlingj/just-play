<?php
  require("sanitizer.php");
  require("database-functions.php");
  //  $baseURL = $FeedbackBaseURL . "?gameID=" . $gameID . "&userID=" . $userID ;
  function update($path, $query, $db) {
  	$gameID=makesafe($query["gameID"]);
  	$userID=makesafe($query["userID"]);
  	givePlayerFeedback($gameID, $userID, $db);
  }
 ?>