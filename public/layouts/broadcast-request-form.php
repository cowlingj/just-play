<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="Jonathan Cowling">
  <meta name="date created" content="19 Feb 2017">
  <meta name="date edited" content="13 Feb 2017">
  <title>Just Play</title>
</head>
<body>

  <?php

  // when form has been submitted carry out the following
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {

    // make inputs safe (prevent XXS)
    $_POST["userLng"] = makeSafe($_POST["lng"]);
    $_POST["userLat"] = makeSafe($_POST["lat"]);
    $_POST["broadcastLng"] = makeSafe($_POST["broadcastLng"]);
    $_POST["broadcastLat"] = makeSafe($_POST["broadcastLat"]);
    $_POST["disabled"] = makeSafe($_POST[getUserInfo("disabled")]);
    $_POST["sport"] = makeSafe($_SESSION["sport"]);
    $_POST["BroadcastId"] = makeSafe($_POST[getUserInfo("uuid")]);    
    
    sendToDb();

    // go to new page
    header('location:justplayformresponse.php');

  }

?>

<?php

  // get rid of extra spaces, slashes and other nasty things
  function makeSafe($input)
  {
      trim($input);
      stripcslashes($input);
      htmlspecialchars($input);
      return $input;
  }

  // function returns the value from a field belonging to a specific user
  function getUserInfo(requiredInfo)
  {
    // connect to the group db, die if connection fails.
    require_once('config.inc.php');  //CHECK FILE PATH
    $mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
    if($mysqli->connect_error)
    {
      die('Connect Error (' .$mysqli->connect_errno . ') '.$mysqli->connect_error);
    }
    $mysqli->select_db('2016_comp10120_m3');

    // fetches a given field from a user
    $mysqli->prepare("SELECT ? FROM users WHERE id = ?");
    $mysqli->bind_param("sd", $requiredInfo, $_SESSION["id"]);
    $mysqli->execute();

    $isUserAMember->store_result();
    $isUserAMember->bind_result($result);
    $mysqli->close();
    return $result;
  }

  function sendToDb()
  {

      $mysqli->prepare("INSERT INTO broadcasts (?, ?, ?, ?, ?)");
      $mysqli->bind_param("dddsb", $_POST["BroadcastId"],
                                   $_POST["broadcastLng"],
                                   $_POST["broadcastLat"],
                                   $_POST["sport"],
                                   $_POST["disabled"]);
      $mysqli->execute();
  }

?>

  <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">
    Lng:<input type="number" name="BroadcastLng">
    Lat:<input type="number" name="BroadcastLat"><br>
    <input type="submit" value="submit">
  </form>
</body>
</html>
