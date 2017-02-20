<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="Jonathan Cowling">
  <meta name="date" content="2 Feb 2017">
  <meta name="date edited" content="13 Feb 2017">
  <title>Just Play Form Response</title>
</head>
<body>
  
  <div id="mapContainer" style="width:100%;height:400px;"></div>
  
  <div id="rankedResponses">
    <?php
      
      // make an inital query to find out the number of rows to include
      $initialQuery = $mysqli->query("SELECT * FROM rankedRequests");
      $responseLength = $initialQuery->num_rows;
      $initialQuery->close();
      
      // loop to print out each match in order of rank
      // assumes that the best rank is 1, and the worst is the number of ranks
      for ($responseCount = 0 ; $responseCount < $responseLength;
           $responseCount++)
      {
        // select a single match based from rank
        $response = $mysqli->prepare("SELECT * FROM rankedRequests
                                     WHERE rank=?");
        $response->bind_param("i", $responseCount + 1);
        $response->execute();
        
        // print out each result
        $response->store_results();
        $response->bind_result($result)
      
        echo $result;
        
        $response->close();
      }
      
    ?>
  </div>

<script type="text/javascript" src="./assets/mapsApi.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHxR3s78HL9NqdVy4FiUulKGyAQre04_w&callback=createMap"></script>

</body>
</html>
