<?php
  // display the map and divs relevant to the user submittin
  function read($path, $query, $db) {

  // make inputs safe (prevent XXS)
  $sport = makeSafe($_GET["sport"]);
  $latitude = $_GET["latitude"];
  $longitude = $_GET["longitude"];
  $disabled = makeSafe($_GET["disabled"]);
  

  // All the current broadcasts for desired sport
  $allBroadcasts = $db->query("SELECT * FROM broadcasts WHERE sport='" . $sport ."'");

  // An ordered array of broadcast recomendation IDs 
  $_SESSION["recomendations"] = getRankedRequests($latitude,
                                                    $longitude,
                                                    $allBroadcasts,
                                                    getElo($userID));

  $orderedRequests = fetchOrderedRequests($_SESSION["recomendations"]);

  layout("response-map");

  }

  // submit the broadcast form and head back to search-response
  function create($path, $query, $db) {

  // make inputs safe (prevent XXS)
  $_POST["userLng"] = makeSafe($_POST["lng"]);
  $_POST["userLat"] = makeSafe($_POST["lat"]);
  $_POST["broadcastLng"] = makeSafe($_POST["broadcastLng"]);
  $_POST["broadcastLat"] = makeSafe($_POST["broadcastLat"]);
  $_POST["disabled"] = makeSafe($_POST[getUserInfo("disabled")]);
  $_POST["sport"] = makeSafe($_SESSION["sport"]);
  $_POST["BroadcastId"] = makeSafe($_POST[getUserInfo("uuid")]);    

  // insert a new broadcast request
  $db->prepare("INSERT INTO broadcasts (?, ?, ?, ?, ?)");
  $db->bind_param("dddsb", $_POST["BroadcastId"],
                           $_POST["broadcastLng"],
                           $_POST["broadcastLat"],
                           $_POST["sport"],
                           $_POST["disabled"]);
  $db->execute();
  
  // READ response.php  

  // All the current broadcasts for desired sport
  $allBroadcasts = $db->query("SELECT * FROM broadcasts WHERE sport='" . $_POST["sport"] ."'");

  // An ordered array of broadcast recomendation IDs 
  $_SESSION["recomendations"] = getRankedRequests($_POST["userLat"],
                                                    $_POST["userLng"],
                                                    $allBroadcasts,
                                                    getElo($userID));

  $orderedRequests = fetchOrderedRequests($_SESSION["recomendations"]);

  layout("response-map");

  }

  // get rid of extra spaces, slashes and other nasty things
  function makeSafe($input) {
      trim($input);
      stripcslashes($input);
      htmlspecialchars($input);
      return $input;
  }

  function getElo($userId) {
    $db -> query("SELECT elo FROM users WHERE id = $userID");
  }
    
?>