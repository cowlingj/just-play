<?php
  //Request controller 
  require("email.php");

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
    $broadcastID = $query["broadcastID"];
    $recieverID =  $query["recieverID"];

    // the broadcast information from the database
    $broadcastInfo = $db->query("SELECT * FROM broadcast WHERE id='$broadcastID'")->fetch_assoc();
    //There isn't a broadcast here
    if ($broadcastInfo==NULL) return;
    
    $sport = $broadcastInfo["sport"];
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
      return;
    //Receiver
    if($db->query("INSERT INTO player (game_id, player_id, starting_elo) VALUES ($gameID, $recieverID, $recieverELO)"))
      return;


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