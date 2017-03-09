<?php require("../../lib/database-functions.php"); ?>
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

  

?>

  <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">
    Lng:<input type="number" name="BroadcastLng">
    Lat:<input type="number" name="BroadcastLat"><br>
    <input type="submit" value="submit">
  </form>
</body>
</html>
