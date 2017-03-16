<?php
  require('../lib/database-functions.php');
  require('../lib/process-search-form.php'); 
?>
<?php submitSearch(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <?= $somevar ?>
    <meta name="author" content="Jonathan Cowling">
    <meta name="date" content="2 Feb 2017">
    <meta name="date edited" content="9 Mar 2017">
    <title>Just Play Form Response</title>
    <script src="../assets/making-markers.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHxR3s78HL9NqdVy4FiUulKGyAQre04_w&callback=initMap"></script>
  </head>
  <body>
    <div id="mapContainer" style="width:100%;height:400px;"></div>
    <div id="rankedResponses">
      <?php
        
         $orderedRequests = fetchOrderedRequests($_SESSION["recomendations"]);

         foreach ($orderedRequests as $request) {
           echo "<p>" . $request["broadcaster"] . " is " . $request["dist"] . " (units) away</p><hr>";  
         }
      ?>
    </div>
  </body>
</html>