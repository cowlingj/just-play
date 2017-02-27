<?php
// get database connection variables from config file
require_once("config.inc.php");

// function that connects to the database
// n.b. config.inc.php must be required
function databaseConnect() {
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
  $mysqli = databaseConnect();

  // initialises the loop counter and the 2-d array that markers will be stored in
  $markerCounter = 0;
  $markers = [][];
  
  // for every marker given as argument
  foreach ($broadcast as $marker) {
    // fetches unique row for desired broadcast request and stores in array
    $query = "SELECT * FROM broadcast WHERE id='" . $marker . ";'";
    $markers[$markerCounter] = $mysqli->query($query);;
    $markerCounter++;
  } // end for every marker

  return $markers; 
} // end fetchOrderedRequests()

?>