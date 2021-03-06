<?php
  require_once("lib/helpers/auth.php");
  require("lib/database-functions.php");

  // display the map and divs relevant to the user submittin
  function read($path, $query, $db) {

    // make inputs safe (prevent XXS)
    $sport = makeSafe($_GET["sport"]);
    $latitude = floatval(makeSafe($_GET["latitude"]));
    $longitude = floatval(makeSafe($_GET["longitude"]));
    $currentUser = getCurrentUser();
    $userID = $currentUser["id"];

    // All the current broadcasts for desired sport
    $allBroadcasts = $db->query("SELECT * FROM broadcast WHERE sport='$sport'")->fetch_all(MYSQLI_ASSOC);

    // An ordered array of broadcast recomendation IDs 
    
    $results = array_map(function ($broadcast) use ($db) {
      $user = $db->query("SELECT * FROM user WHERE id=".$broadcast["broadcaster"])->fetch_assoc();
      $loc = $db->query("SELECT * FROM location WHERE id=".$broadcast["location"])->fetch_assoc();
      return array(
        "broadcaster" => $broadcast["broadcaster"],
        "latitude" => $loc["latitude"],
        "longitude" => $loc["longitude"],
        "elo" => $user["elo"]
      );
    }, $allBroadcasts);
    
    $_SESSION["recomendations"] =
      getRankedRequests($latitude, $longitude, $results, getElo($userID, $db));
    

    // ordered array of broadcasts and their information
    $orderedRequests = fetchOrderedRequests($_SESSION["recomendations"], $db);

    print_r($orderedRequests);

    require layout("search-map");
  }

  // submit the broadcast form and head back to search-response
  function create($path, $query, $db) {
      print_r($_POST);

    // make inputs safe (prevent XXS)
    $broadcastLng = makeSafe($_POST["longitude"]);
    $broadcastLat = makeSafe($_POST["latitude"]);
    $_POST["sport"] = makeSafe($_POST["sport"]);
    $_POST["BroadcastId"] = getCurrentUser()["id"];
    $locationName = makeSafe($_POST["location"]);
    
    $db->query("INSERT INTO location (name, latitude, longitude) VALUES ($locationName, $broadcastLat, $broadcastLng)");

    // insert a new broadcast request
    $q = $db->prepare("INSERT INTO broadcasts (broadcaster, reciever, location, sport) VALUES (?, ?, ?, ?)")->bind_param("ddds", $_POST["BroadcastId"],
                             $_POST["BroadcastId"],
                             $location["id"],
                             $_POST["sport"]);
                             $q->execute();
    
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
    $result = $db ->query("SELECT elo FROM user WHERE id=$userID")->fetch_assoc();
    return $result["elo"];
  }
?>
