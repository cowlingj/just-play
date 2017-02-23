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
  $_SESSION["locationX"] = null;
  $_SESSION["locationY"] = null;
  $_SESSION["disabled"] = null;

  // when form has been submitted carry out the following
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    // make inputs safe (prevent XXS)
    $_SESSION["name"] = makeSafe($_POST["name"]);
    $_SESSION["sport"] = makeSafe($_POST["sport"]);
    $_SESSION["locationX"] = makeSafe($_POST["locationX"]);
    $_SESSION["locationY"] = makeSafe($_POST["locationY"]);
    $_SESSION["disabled"] = makeSafe($_POST["disabled"]);

    // ROBBIE'S FUNCTION TO SEND INPUTS TO DB...
    
    // go to new page
    header('location:justplayformresponse.php');

/*
    // check inputs are valid
    $errors = validateInput();

    if(! $errors)
    {
      // ROBBIE'S FUNCTION TO SEND INPUTS TO DB...
    
    sendRequest(); 

 

    $_POST["name"] = $_SESSION["name"];
    $_POST["sport"] = $_SESSION["sport"];
    $_POST["locationX"] = $_SESSION["locationX"];
    $_POST["locationY"] = $_SESSION["locationY"];
    $_POST["disabled"] = $_SESSION["disabled"];


    
    }
  */

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
    require_once('../config.inc.php');
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
      

  // will check each input matches an expression
  function validateInput()
  {
    //first check for valid name
    if (!preg_match("/^[a-zA-Z ]*$/",$_SESSION["name"]))
    {
      print "Invalid name: only letters and white space allowed";
      return TRUE;
    }
    //check locatonX is a number
    else if (!preg_match("/^[0-9.,]*$/",$_SESSION["locationX"]))
    {
      print "Location not recognised";
      return TRUE;
    }
    //check locationY is a number
    else if (!preg_match("/^[0-9.,]*$/",$_SESSION["locationY"]))
    {
      print "Location not recognised";
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }
*/

  ?>

  <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>">
    Name:<input type="text" name="name"
                pattern="[A-Za-z ]+" title="Letters and spaces only"><br>
    Sport:<select name="sport">
            <option value="football">Football</option>
            <option value="rugby">Rugby</option>
            <option value="basketball">Basketball</option>
            <option value="tennis">Tennis</option>
          </select><br>
    Location x:<input type="number" name="locationX">
    Location y:<input type="number" name="locationY"><br>
    Disabled:<input type="checkbox" name="disabled"><br>
    <input type="submit" value="submit">
  </form>
</body>
</html>