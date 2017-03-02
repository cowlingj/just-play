<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>User Location on Map</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
      }
      #map {
        width: 100%;
        height: 100%;
      }
      /*#legacy { display: none; }
      #permission-denied { display: none; }*/
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9ofPjKpQ3eRwJFOwPgP-BBXgTn9phis"></script>
    <script src="./assets/js/map.js"></script>
    <script src="./assets/js/marker-generator.js"></script>
  </head>
  <body>
    <h1>MAP</h1>
    <div id="legacy">
      <!-- <h2>Hello Old People</h2> -->
    </div>
    <div id="permission-denied">
      <!-- <h2>Hello Those in Denial</h2> -->
    </div>
    <div id="map">
      <!-- where the map will be displayed -->
    </div>
  </body>
</html>