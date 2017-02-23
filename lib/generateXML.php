<?php
// get database connection variables from config file
require_once("config.inc.php");

$mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);

// if the connection fails
if ($mysqli->connect_error) {
  die("Connection error (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
} // end if the connection fails
$mysqli->select_db("2016_comp10120_m3");


/* this stuff doesn't work, ask Jonathan about sql command on */

// retrieve the necessary users from table (along with their locations)`
$query = "SELECT ? FROM users WHERE id = ?";
$mysqli->prepare($query);
$mysqli->bind_param("sd", $requiredInfo, $_SESSION["id"]);
$mysqli->execute();

/*  */

// this creates an XML file which will contain nodes for each
// person in the given area
$xmlDocument = new DOMDocument("1.0");
$node = $xmlDocument->create_element("markers");
$parentNode = $xmlDocument->append_child($node);

header("Content-type: text/xml");

// loop through all people in desired area and create node for each 
while ($requestRow = mysql_fetch_assoc($result)) { // need to change to mysqli type
  // adding children to parent element
  $node = $xmlDocument->create_element("marker");
  $newNode = $parentNode->append_child($node);

  // add the location information inside node attributes
  $newNode->setAttribute("name", $requestRow["name"]);
  $newNode->setAttribute("latitude", $requestRow["latitude"]);
  $newNode->setAttribute("longitude", $requestRow["longitude"]);
} // end looping through all suggestions

// print to the screed the type of document this is
print($xmlDocument->saveXML());

?>