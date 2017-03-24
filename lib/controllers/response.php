<?php
  require_once("lib/helpers/auth.php");
  require("lib/database-functions.php");

  // display the map and divs relevant to the user submittin
  function read($path, $query, $db) {
    // make inputs safe (prevent XXS)
    $sport = makeSafe($_GET["sport"]);
    $latitude = floatval(makeSafe($_GET["latitude"]));
    $longitude = floatval(makeSafe($_GET["longitude"]));
    $userID = getCurrentUser();

    // All the current broadcasts for desired sport
    $allBroadcasts = $db->query("SELECT * FROM broadcasts WHERE sport='" . $sport ."'")->fetch_all();

    // An ordered array of broadcast recomendation IDs 
    $_SESSION["recomendations"] = getRankedRequests($latitude, $longitude, $allBroadcasts, getElo($userID, $db));

    // ordered array of broadcasts and their information
    $orderedRequests = fetchOrderedRequests($_SESSION["recomendations"]);

    require layout("search-map");
  }

  // submit the broadcast form and head back to search-response
  function create($path, $query, $db) {
      

    // make inputs safe (prevent XXS)
    $_POST["userLng"] = floatval(makeSafe($_POST["l
    $_POST["userLat"] = floatval(makeSafe($_POST["at"]));
    $_POST["broadcastLng"] = floatval(makeSafe($_POST["broadcastLng"]));
    $_POST["broadcastLat"] = floatval(makeSafe($_POST["broadcastLat"]));
    $_POST["disabled"] = makeSafe($_POST[getUserInfo("disabled")]);
    $_POST["sport"] = makeSafe($_SESSION["sport"]);
    $_POST["BroadcastId"] = $userID;    

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

    require layout("response-map");

  }

  // get rid of extra spaces, slashes and other nasty things
  function makeSafe($input) {
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }

  function getElo($userID, $db) {
    $result = $db -> query("SELECT elo FROM user WHERE id = $userID")->fetch_assoc();
    return $result["elo"];
  }
?>
