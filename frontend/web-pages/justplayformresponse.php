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
    
      // an ordered array cointaining references to all matches
      $rankedMatches = getrankedMatches(uerserID);
    
      foreach ($rankedMatches as $rankedMatch)
      {
       echo("<div>$rankedMatch</div>")
      }
      unset ($rankedMatch)
    
    ?>
  </div>

<script type="text/javascript" src="../api/mapsApi.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHxR3s78HL9NqdVy4FiUulKGyAQre04_w&callback=createMap"></script>

</body>
</html>
