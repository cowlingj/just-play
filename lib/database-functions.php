<?php
// get database connection variables from config file
require_once("config.inc.php");
require_once("magic.php");
// function that connects to the database
// n.b. config.inc.php must be required
// For simplic ity database connection never closess
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
function givePlayerFeedback($gameID, $playerID, $outcome){
   //databaseConnect() should be called at the beginning but for safety call it always
   databaseConnect();

   //if ($outcome<0 || $outcome>2) throw new Exception('Invalid match oucome supplied.'); 

   //First check if such a game still exists in the gamebuffer
   $query = "SELECT * FROM gamebuffer WHERE game_id=" . $gameID . ";";
   $gamebufferResult = $mysqli->query($query);
   if($gamebufferResult->num_rows==0)  return false;

   //Find the game which the player says they played
   $query = "SELECT * FROM game WHERE id=" . $gameID . ";";
   $gameResult = $mysqli->query($query)->fetch_assoc();

   //Check if the player is player1
   if ($result["player1"]==$playerID){
      //player submitting feedback is player 1
      if($gamebufferResult["player1_feedback"]!=null){
         //Player1 already submitted feedback
         return false;
      }else{
         //Submit player1 feedback
         $query= "UPDATE gamebuffer SET gamebuffer.player1_feedback=".MatchOutCome::toString($outcome)." WHERE gamebuffer.game_id=".$gameID.";"
      }
   }else if ($result["player2"]==$playerID){
      //player submitting feedback is player 2
      if($gamebufferResult["player2_feedback"]!=null){
         //Player2 already submitted feedback
         return false;
      }else{
         //Submit player2 feedback
         $query= "UPDATE gamebuffer SET gamebuffer.player2_feedback=".MatchOutCome::toString($outcome)." WHERE gamebuffer.game_id=".$gameID.";"
      }


   }else{
      //A player tried to submit feedback for a game they haven't player
      return false;
   }
   //Finally execute the query
   $mysqli->query($query);
   return true;
   //gamebuffer: game_id, player1_elo, player2_elo, player1_feedback, player2_feedback
}

/**
 * !!! ASSUMES INPUT IS STERILE
 * A function called when a player tries to give feedback
 * @param int $playerID  The ID of they player 
 * @return boolean Does the player have a game they haven't given the result of 
 */
function shouldPlayerGiveFeedback($plyId){
   //TODO:
}

function getCorrespondingBroadcast(){
  return = $mysqli -> query('SELECT * FROM broadcasts WHERE id = $_SESSION["userId"]')
    ->fetch_assoc();
}
?>
