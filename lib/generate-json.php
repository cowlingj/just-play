<?php

require_once("database-functions.php");
require_once("markers.class.php");
require_once("marker.class.php");

$broadcastRequests = fetchOrderedRequests($_SESSION["recomendations"]);

$counter = 0;
$markers = array();

// loop through each broadcast request and create object
foreach ($broadcastRequests as $request) {
  $markers[$counter] = new Marker($request->broadcaster, $request->location);
  $counter++;
} // end foreach broadcast request

$parentMarkersObject = new Markers($markers);

print(json_encode($parentMarkersObject));

/* the printed json should resemble:
  
  {
    "markers": {
      "marker": [
        {
          "name": "john",
          "latitude": 53.4682282,
          "longitude": -2.238547
        }
      ]
    }
  }
 */

?>