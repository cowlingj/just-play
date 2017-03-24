<?php
require_once 'config.inc.php';
require_once 'MailManager.php';

require_once("database-functions.php");
$FeedbackBaseURL = "justplay.com/feedback";

$templateBody=<<<EOD
You recently played a game at %Location%.
Please tell us the outcome of the game
Win:%WinURL%
Lose:%LoseURL%
Draw:%DrawURL%
EOD;
/**
 * Sends an email to the selected email address with the game feedback form
 * @param string $userEmail The email address of the player
 * @param string $location The location of the game the player is giving feedback for 
 * @param string $userID The database key of the user
 * @param string $gameID The database key for the game 
 * @param string $securityKey A randomly generated key to prevent users from spoofing other player's results
 */
function sendFeedbackEmailToPerson($userEmail, $location, $userID, $gameID) {
  $baseURL = $FeedbackBaseURL . "?gameID=" . $gameID . "&userID=" . $userID . "&key=" . $securityKey;
  
  $winURL  = $baseURL . "&result=WIN";
  $loseURL = $baseURL . "&result=LOSE";
  $drawURL = $baseURL . "&result=DRAW";
  
  $emailBody = $templateBody;
  
  str_replace("%Location%", $location, $emailBody);
  
  str_replace("%WinURL%",   $winURL,  $emailBody);
  str_replace("%LoseURl%",  $loseURL, $emailBody);
  str_replace("%DrawURL%",  $drawURL, $emailBody);
  
  try {
    $mm = new MailManager($database_host, $database_user, $database_pass, $database_name);
    $mm->set_subject('Just play feedback.');
    $mm->add_recipient($userEmail);
    $mm->set_body($emailBody);
    $mm->send();
  } catch (Exception $e){
    die("Email error: ".$e->getMessage()."\n");
  }
}
?>

