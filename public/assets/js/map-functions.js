var json;
var map;


// takes parsed JSON object containing marker information and creates a pin on the google map
function printMarkers(markers) {
  var markerCounter = 0;
  var markerArray = [];

  // loop through every marker that has been generated inside the JSON file
  markers.forEach(function(marker) {
    markerArray[markerCounter] = new google.maps.Marker({
      position: new google.maps.LatLng(marker.latitude, marker.longitude),
      map: map
    }); // end marker object
    
    markerCounter++;
  });
} // end printMarkers()


// function that retrieves the user'scurrent gps position
function getUserPosition(mapContainer, lat, lng) {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      // taking the position reference of user's location 
      // information from the GeoLocation API to 
      // create new LatLng object with new center
      function getPosition(position) {
        /* this is removed so that I can get the map center from session variable
        // getting the user's gps position
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        */

        // options and settings for map
        var mapOptions = {
          center: new google.maps.LatLng(lat, lng),
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          disableDefaultUI: true
        };

        map = new google.maps.Map(mapContainer, mapOptions);

        // TODO: we need to get the map center from the server - not the user (rewrite ajax generation)
        // perform ajax request
        if ((ajaxRequest.readyState == 4) && (ajaxRequest.status == 200)) {
          json = ajaxRequest.responseText;
          json = JSON.parse(json);
          printMarkers(json);
        } // end if ajax request
      }
    );
  } else {
    console.log("GeoLocation not supported");
  }
} // end getUserPosition()