<?php
  // display the map and divs relevant to the user submittin
  function read($path, $query, $db) {

  // SHOULDN'T NEED TO DECLARE - Jonathan 13/03/17
  // declare values in the form
  // $userID = null;
  // $sport = null;
  // $latitude = null;
  // $longitude = null;
  // $disabled = null;

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

    layout("search-response");

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
  
  // HOW DO I DO THAT WITH THIS FRAMEWORK!?
  sendToDb();

  // SHOULDN'T USE HEADER - Jonathan 13/03/17
  // go to new page
  // header('location:justplayformresponse.php');
  
  layout("search-response");

  }

  // get rid of extra spaces, slashes and other nasty things
  function makeSafe($input) {
      trim($input);
      stripcslashes($input);
      htmlspecialchars($input);
      return $input;
  }

  // IF THIS SHOULDN'T BE HERE THEN WHERE DOES IT GO, AND HOW DO I USE IT!?
  function getElo($userId) {
    databaseConnect() -> query("SELECT elo FROM users WHERE id = $userID");
  }
    
?>