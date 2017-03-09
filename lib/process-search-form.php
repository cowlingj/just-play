<?php

  // declare values in the form
  $userID = null;
  $sport = null;
  $latitude = null;
  $longitude = null;
  $disabled = null;

  // when form has been submitted carry out the following
  function submitSearch() {

    // make inputs safe (prevent XXS)
    $sport = makeSafe($_GET["sport"]);
    $latitude = $_GET["latitude"];
    $longitude = $_GET["longitude"];
    $disabled = makeSafe($_GET["disabled"]);
 

    // All the current broadcasts for desired sport
    $allBroadcasts = databaseConnect() -> query("SELECT * FROM broadcasts WHERE sport='" . $sport ."'");

    // An ordered array of broadcast recomendation IDs 
    $_SESSION["recomendations"] = getRankedRequests($latitude,
                                                    $longitude,
                                                    $allBroadcasts,
                                                    getElo($userID));
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
  
  ?>
