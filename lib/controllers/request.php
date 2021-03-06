<?php
  //Request controller 
  require("lib/email.php");
  require("lib/helpers/sanitizer.php");

  function getElo($userID, $db) {
    $result = $db -> query("SELECT elo FROM user WHERE id = $userID")->fetch_assoc();
    return $result["elo"];
  }
  function getEmail($userID, $db) {
    $result = $db -> query("SELECT email FROM user WHERE id = $userID")->fetch_assoc();
    return $result["email"];
  }

  function getLocationName($locationID, $db) {
    $result = $db -> query("SELECT name FROM location WHERE id = $locationID")->fetch_assoc();
    return $result["name"];
  }
  function read($path, $query, $db) {
    // the broadcast information from the query string
    $broadcastID = makeSafe($query["broadcastID"]);
    $recieverID =  makeSafe($query["recieverID"]);

    // the broadcast information from the database
    $broadcastInfo = $db->query("SELECT * FROM broadcast WHERE id='$broadcastID'");
    //There isn't a broadcast here
    if ($broadcastInfo==false && $broadcastInfo->num_rows==0) return;
    $broadcastInfo=$broadcastInfo->fetch_assoc();

    $sport    = $broadcastInfo["sport"];
    $location = $broadcastInfo["location"];

    // creating the game from broadcast information
    if (!$db->query("INSERT INTO game (sport, location) VALUES ($sport,$location)"))
      return;
    $gameID= $db->insert_id;

    //Create corresponding player rows 
    $broadcasterID=$broadcastInfo["broadcaster"];

    $recieverELO=getElo($recieverID,   $db);
    $broacastELO=getElo($broadcasterID,$db);
    //Broadcaster
    if(!$db->query("INSERT INTO player (game_id, player_id, starting_elo) VALUES ($gameID, $broadcasterID, $broacastELO)"))
      die("Couldn't create broadcaster with id:$broadcasterID");
    //Receiver
    if($db->query("INSERT INTO player (game_id, player_id, starting_elo) VALUES ($gameID, $recieverID, $recieverELO)"))
      die("Couldn't create receiver with id:$recieverID");

    // physically deleting the broadcast from the table
    $db->query("DELETE * FROM broadcast WHERE id='$broadcastID'");

    //SEND EMAIL TO BOTH USERS
    $broadcasterEmail =getEmail($broadcasterID, $db);
    $receiverEmail    =getEmail($recieverID, $db);
    $locationName     =getLocationName($location, $db);

    //function sendFeedbackEmailToPerson($userEmail, $location, $userID, $gameID) 

    sendFeedbackEmailToPerson($broadcasterEmail, $locationName, $broadcasterID, $gameID);

    sendFeedbackEmailToPerson($receiverEmail, $locationName, $recieverID,       $gameID);
    // 

    // redirect to whatever route you need
    require layout('view-accepted-broadcast');
  }




?>