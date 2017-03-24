<?php
// get database connection variables from config file
require_once("config.inc.php");
require_once("match-making.php");
// function that connects to the database
// n.b. config.inc.php must be required
// For simplicity database connection never closess

// retrieves array of information about each broadcast request, when given broadcast IDs (from session variable)
function fetchOrderedRequests($broadcasts, $db) {

  // initialises the loop counter and the 2-d array that markers will be stored in
  $markerCounter = 0;
  $markers =  [];
  
  // for every marker given as argument
  foreach ($broadcast as $marker) {
    // fetches unique row for desired broadcast request and stores in array
    $query = "SELECT * FROM broadcast WHERE id=" . $marker . ";";
    $markers[$markerCounter] = $db->query($query);
    $markerCounter++;
  } // end for every marker

  return $markers; 
} // end fetchOrderedRequests()

function givePlayerFeedback($gameID, $playerID, $outcome, $db){
   //First get the relevant player from the player table
   $query = "SELECT * FROM player WHERE game_id=" . $gameID . " AND player_id=".$playerID;

   $playerResult = $db->query($query);

   if($playerResult->num_rows==0)  return false;

   $player= $playerResult->fetch_assoc();

   if($player["feedback"]==null){
   	$query= "UPDATE player SET feedback=".MatchOutCome::toString($outcome)." WHERE player_id=".$player_id." AND game_id=".$game_id.";";
   }else die("Player already gave feedback.");

   //Finally execute the query
   $db->query($query);

   //Get other player id
   $query = "SELECT * FROM player WHERE game_id=" . $gameID . " AND player_id!=".$playerID;
   //Hacks
   $otherPlayerID = $db->query($query);
   $otherPlayerID =$otherPlayerID["player_id"];
   //Force update even if half of the time the other player isn't going to have given feedback yet
   updatePlayersElosOnFeedback($playerID,$otherPlayerID,$db);
   return true;
}

function shouldUserGiveFeedback($user, $db){
  //Construct query
  $query = "SELECT * FROM player WHERE player_id=".$playerID.";";
  $result= $mysqli->query($query);

  while ( $row = $result->fetch_assoc() ) {
    if($row["feedback"]==null) return true;
  }
  return false;
}

function updatePlayersElosOnFeedback($player1ID, $player2ID, $db){

  //First get player 1 and player 2 elos
  $query = "SELECT * FROM player WHERE player_id=".$player1ID.";";
  $player1 = $db->query($query)->fetch_assoc();

  $query = "SELECT * FROM player WHERE player_id=".$player2ID.";";
  $player2 = $db->query($query)->fetch_assoc();
  if($player1==null || $player2==null || $player1["feedback"]== null || $player2["feedback"]==null) return false;
  
  //Get get outcome of player1 from both perspectives
  $player1Outcome=MatchOutCome::toNumber($player1["feedback"]);
  $player2Outcome=MatchOutCome::getOppositeOutcome(MatchOutCome::toNumber($player2["feedback"]));
  //If players disagree set outcome to DRAW otherwise set agreed outcome
  $outcome = ($player1Outcome==$player2Outcome ? $player1Outcome : MatchOutCome::DRAW);
  $newElo = recalculateElo($player1["starting_elo"], $player2["starting_elo"], $outcome);

  //UPDATE user elos 

  //Player 1 
  $query = "UPDATE user set elo=".$newElo["ply1"]." WHERE id=".$player1ID.";";
  if(!$db->query($query)) die("1Failed to update elo of user:$player1ID");

  //Player 2
  $query = "UPDATE user set elo=".$newElo["ply2"]." WHERE id=".$player2ID.";";
  if(!$db->query($query)) die("2Failed to update elo of user:$player2ID");


  //Finally remove the 2 player rows
  $query = "DELETE FROM player WHERE player_id=".$player1ID.";";
  $db->query($query);

  $query = "DELETE FROM player WHERE player_id=".$player2ID.";";
  $db->query($query);

}
function getCorrespondingBroadcast($db){
  return $db -> query('SELECT * FROM broadcasts WHERE id = $_SESSION["userId"]')->fetch_assoc();
}
function gotoIfNotIn($path){
  $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  if($path!=$requestPath){
    header("Location: " . $path);
  }
}
//A function that checks to see if users is in the right page
function checkUserState($userID, $db){
  $result = $db -> query("SELECT * FROM broadcast WHERE broadcaster = $userID")->fetch_assoc();

  //User is a broadcaster
  if(!is_null($result)){
    //view broadcast
    gotoIfNotIn("/view-broadcast");
  }else{
    //Get all the players the user is 
    $result= $db -> query("SELECT * FROM player WHERE player_id=".$playerID.";");
    $hasFeedBackToGive=false;
    while ( $row = $result->fetch_assoc() ) {
      if($row["feedback"]==null){//If not given feedback for game 
          //Time for feedback has ended so force feedback
          //Does not handle the case when a player never searches for a game after the first feedback
          if(($row["timestamp"]-time())>60*60*24*2){
            givePlayerFeedback($row["game_id"],$row["player_id"],MatchOutCome::DRAW, $db);
            break;
          }
          $hasFeedBackToGive = true;
        }


      }
      if($hasFeedBackToGive==true){
        gotoIfNotIn("/view-accepted-broadcast");
        //View accepted broadcast
      }else{
        gotoIfNotIn("/search-form");
      }
    //User is a player in a game
    //
  }
}
?>
