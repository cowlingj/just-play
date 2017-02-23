<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="Jonathan Cowling">
  <meta name="date" content="2 Feb 2017">
  <meta name="date edited" content="16 Feb 2017">
  <title>Just Play Form Response</title>
</head>
<body>
  
  <div id="mapContainer" style="width:100%;height:400px;"></div>
  
  <div id="rankedResponses">
    
    <?php
    
      require("../lib/konstantinsFCN.php")
    
    ?>
    <script type="text/javascript">
      //adapted from joel's maps.js file
      var lat = None;
      var lng = None;
      
      // if GeoLocation API is supported in browser
      if (navigator.geolocation)
      {
        navigator.geolocation.getCurrentPosition
        (
        // taking the position reference of user's location 
        // information from the GeoLocation API to 
        // create new LatLng object with new center
          function getPosition(position)
          {
            // getting the user's gps position
            global lat = position.coords.latitude;
            global lng = position.coords.longitude;
          },
          // incompatable with firefox
          function errorCallback(error) {
            if (error.code == error.PERMISSION_DENIED)
            {
              permissionDeniedContainer.innerHTML = "You denied location permission, silly!";
            } // end if geoLocation denied
          }
        );
      }
    </script>
    
    <?php

      // an ordered array cointaining references to all matches
      $rankedMatches = getrankedRequests($_SESSION[userID], lat, lng);
    
      foreach ($rankedMatches as $rankedMatch)
      {
       echo("<div>$rankedMatch</div>")
      }
      unset ($rankedMatch)
    
    ?>
  </div>

<script type="text/javascript" src="../api/mapsApi.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=key=AIzaSyDP9ofPjKpQ3eRwJFOwPgP-BBXgTn9phis&callback=createMap"></script>

</body>
</html>
