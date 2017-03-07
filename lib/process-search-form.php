<?php

  // declare values in the form
  $userID = null;
  $sport = null;
  $latitude = null;
  $longitude = null;
  $disabled = null;

  // when form has been submitted carry out the following
  function submitSearch {

    // make inputs safe (prevent XXS)
    $userID = makeSafe($_POST["userID"]);
    $sport = makeSafe($_POST["sport"]);
    $latitude = makeSafe($_POST["latitude"]);
    $longitude = makeSafe($_POST["longitude"]);
    $disabled = makeSafe($_POST["disabled"]);
 
    // set session variables relevant to the user (their ID, and location information)
    $_SESSION["userID"] = $userID;
    $_SESSION["longitude"] = $longitude;
    $_SESSION["latitude"] = $latitude;

    // All the current broadcasts for desired sport
    $allBroadcasts = databaseConnect() -> query("SELECT * FROM broadcasts WHERE sport='" . $sport ."'");

    // An array of broadcast recomendation IDs 
    $_SESSION["recomendations"] = getRankedRequests($_SESSION["latitude"],
                                                    $_SESSION["longitude"],
                                                    $allBroadcasts,
                                                    getElo($userID));

    // go to results page
    header('Location: search-response.php');
  }

  // get rid of extra spaces, slashes and other nasty things
  function makeSafe($input) {
      trim($input);
      stripcslashes($input);
      htmlspecialchars($input);
      return $input;
  }

  function getElo($userId) {
    databaseConnect() -> query("SELECT elo FROM users WHERE id = $userID");
  }

  function create($query, $uri, $db) {

    layout("search-response")
  }
  
?>
