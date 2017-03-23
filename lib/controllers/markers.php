<?php

require_once("database-functions.php");


function read($path, $query, $db) {

  $broadcastRequests = fetchOrderedRequests($_SESSION["recomendations"]);

  $markers = array_map(function ($request) {
    $result = $db->query("SELECT latitude, longitude FROM location WHERE id='" . $request->location . "'");

    if (!$result) {
      die("You fucked up mate");
    } 

    $location = $result->fetch_assoc();

    $result->free();

    return array(
      "name" => $request->broadcaster,
      "latitude" => $location["latitude"],
      "longitude" => $location["longitude"]
    );
  }, $broadcastRequests);

  header("Content-Type: application/json");
  echo json_encode($markers);
}
/* the printed json should resemble:
[
  {
    "name": "john",
    "latitude": 53.4682282,
    "longitude": -2.238547
  },
  {
      
  }
]
 */
?>