<?php
// get database connection variables from config file
require_once("config.inc.php");
require_once("magic.php");
// function that connects to the database
// n.b. config.inc.php must be required
// For simplicity database connection never closess
$mysqli = null;
function databaseConnect() {
  if ($mysqli != null) return; 

  $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);

  // if the connection fails
  if ($mysqli->connect_error) {
    die("Connection error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
  } // end if the connection fails

  $mysqli->select_db("2016_comp10120_m3");

  return $mysqli;
} // end databaseConnectBroadcast()


// retrieves array of information about each broadcast request, when given broadcast IDs (from session variable)
function fetchOrderedRequests($broadcasts) {
   databaseConnect();

  // initialises the loop counter and the 2-d array that markers will be stored in
  $markerCounter = 0;
  $markers =  [];
  
  // for every marker given as argument
  foreach ($broadcast as $marker) {
    // fetches unique row for desired broadcast request and stores in array
    $query = "SELECT * FROM broadcast WHERE id=" . $marker . ";";
    $markers[$markerCounter] = $mysqli->query($query);
    $markerCounter++;
  } // end for every marker

  return $markers; 
} // end fetchOrderedRequests()
/**
 * !!! ASSUMES INPUT HAS IS STERILE
 * A function called when a player tries to give feedback
 * @param int $gameID the ID of the game that the player is sumbitting feedback for 
 * @param int $playerID the ID of the player who is sumbitting feedback
 * @param MatchOutCome $outcome the outcome in the match represented in an enum
 * @return boolean Did the player successfully submit their feedback
 */
function givePlayerFeedback($gameID, $playerID, $outcome,$securityKey){
   //databaseConnect() should be called only once in the  beginning but for safety call it always
   databaseConnect();

   //First get the relevant player from the player table
   $query = "SELECT * FROM player WHERE game_id=" . $gameID . " AND player_id=".$playerID." AND key=".$securityKey.";";

   $playerResult = $mysqli->query($query);
   //There isn't an active player in the table or key was incorrect
   if($playerResult->num_rows==0)  return false;

   $player= $playerResult->fetch_assoc();

   if($player["feedback"]==null){
   	$query= "UPDATE player SET feedback=".MatchOutCome::toString($outcome)." WHERE player_id=".$player_id." AND game_id=".$game_id.";";
   }else return false;

   //Finally execute the query
   $mysqli->query($query);
   return true;
   //player :game_id, player_id, starting_elo, feeedback
}

/**
 * A function called when a player tries to give feedback
 * @param int $playerID  The ID of the player 
 * @return boolean Does the player have a game they haven't given the result of 
 */
function shouldPlayerGiveFeedback($playerID){
  databaseConnect();
  //Construct query
  $query = "SELECT * FROM player WHERE player_id=".$playerID.";";

  $result= $mysqli->query($query)->fetch_assoc();

  if($result==null || $result["feedback"]!=null)
    return false;
  else
    return true;
}
/**
 * Updates the player elo's after both players have submitted feedback or the feedback time slot has expired
 * @param int $player1ID  The ID of  player1
 * @param int $player2ID  The ID of  player2
 * @return boolean Was the update successful
 */
function UpdatePlayersElosOnFeedback($player1ID, $player2ID){
  databaseConnect();

  //First get player 1 and player 2 elos
  $query = "SELECT * FROM player WHERE player_id=".$player1ID.";";
  $player1 = $mysqli->query($query)->fetch_assoc();

  $query = "SELECT * FROM player WHERE player_id=".$player2ID.";";
  $player2 = $mysqli->query($query)->fetch_assoc();
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
  $mysqli->query($query);

  //Player 2
  $query = "UPDATE user set elo=".$newElo["ply2"]." WHERE id=".$player2ID.";";
  $mysqli->query($query);

  //Finally remove the 2 player rows
  $query = "DELETE FROM player WHERE player_id=".$player1ID.";";
  $mysqli->query($query);

  $query = "DELETE FROM player WHERE player_id=".$player2ID.";";
  $mysqli->query($query);

}
function getCorrespondingBroadcast(){
  return $mysqli -> query('SELECT * FROM broadcasts WHERE id = $_SESSION["userId"]')
    ->fetch_assoc();
}
?>
