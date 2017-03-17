<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="Jonathan Cowling">
  <meta name="date created" content="1 Feb 2017">
  <meta name="date edited" content="13 Feb 2017">
  <title>Just Play</title>
</head>
<body>

  <?php

  // declare values in the form
  $_SESSION["name"] = null;
  $_SESSION["sport"] = null;
  $_SESSION["latitude"] = null;
  $_SESSION["longitude"] = null;
  $_SESSION["disabled"] = null;

  // when form has been submitted carry out the following
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    // make inputs safe (prevent XXS)
    $_SESSION["name"] = makeSafe($_POST["name"]);
    $_SESSION["sport"] = makeSafe($_POST["sport"]);
    $_SESSION["latitude"] = makeSafe($_POST["latitude"]);
    $_SESSION["longitude"] = makeSafe($_POST["longitude"]);
    $_SESSION["disabled"] = makeSafe($_POST["disabled"]);

    // robbie's function
    sendRequest(); 
 
    $_POST["name"] = $_SESSION["name"];
    $_POST["sport"] = $_SESSION["sport"];
    $_POST["locationX"] = $_SESSION["locationX"];
    $_POST["locationY"] = $_SESSION["locationY"];
    $_POST["disabled"] = $_SESSION["disabled"];

    // go to new page
    header('location:justplayformresponse.php');
  }

  // get rid of extra spaces, slashes and other nasty things
  function makeSafe($input)
  {
      trim($input);
      stripcslashes($input);
      htmlspecialchars($input);
      return $input;
  }

  // Function to send to the database.
  function sendRequest()
  {
    /* this function needs to be updated to 'INSERT' data into the database */
    require_once('../lib/config.inc.php');
    $conn = new msqli(database_host, database_user, database_pass,
                      group_dbnames[0]);
    if($conn->connect_error())
    {
      die("Connection failed: " . $conn->connect_error());
    } 

    $opponent = "SELECT name FROM users";
    $result = $conn->query($opponent);
   
    if ($result->num_rows > 0)
    {
      while($row = $result->fetch_assoc())
      {
        echo "You have been matched with " . $row["name"];
      }
    }
    else
    {
      echo "No oppent found";
    } 
    $conn->close();
  } 
  
  ?>

  <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">
    Name:<input type="text" name="name" required><br>
    Sport:<select name="sport" required>
            <option value="football">Football</option>
            <option value="rugby">Rugby</option>
            <option value="basketball">Basketball</option>
            <option value="tennis">Tennis</option>
          </select><br>
    <!-- 
        by the end of sprint 2 this information will be obtained
        via javascript, so no form inputs will be required
    -->
    Location x y:<input type="number" name="latitude" required><input type="number" name="longitude" required><br>
    Disabled:<input type="checkbox" name="disabled"><br>

    <input type="submit" value="submit">
  </form>
</body>
</html>