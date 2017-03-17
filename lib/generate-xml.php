<?php

require_once("database-functions.php");

// array of ordered broadcast requests for marker creation
$orderedRequests = fetchOrderedRequests($_SESSION["recommendations"]);

// this creates an XML file which will contain nodes for each
// person in the given area
$xmlDocument = new DOMDocument("1.0");
$node = $xmlDocument->create_element("markers");
$parentNode = $xmlDocument->append_child($node);

header("Content-type: text/xml");

// loop through all people in desired area and create node for each 
foreach ($orderedRequests as $broadcastRequest) { 
  // adding children to parent element
  $node = $xmlDocument->create_element("marker");
  $newNode = $parentNode->append_child($node);

  // add the location information inside node attributes
  $newNode->setAttribute("broadcaster", $broadcastRequest["broadcaster"]);
  $newNode->setAttribute("latitude", $broadcastRequest["latitude"]);
  $newNode->setAttribute("longitude", $broadcastRequest["longitude"]);
} // end looping through all suggestions

// print to the screen the type of document this is
print($xmlDocument->saveXML());

?>