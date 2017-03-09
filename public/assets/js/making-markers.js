var ajaxRequest = new XMLHttpRequest;
var json;
var map;


// takes parsed JSON object containing marker information and creates a pin on the google map
function printMarkers(object) {
  var markerCounter = 0;
  var markerArray = [];

  // loop through every marker that has been generated inside the JSON file
  object.markers.marker.forEach(function(marker) {
    markerArray[markerCounter] = new google.maps.Marker({
      position: new google.maps.LatLng(marker.latitude, marker.longitude),
      map: map
    }); // end marker object
    
    markerCounter++;
  });
} // end printMarkers()


// function that retrieves the user'scurrent gps position
function getUserPosition(mapContainer) {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      // taking the position reference of user's location 
      // information from the GeoLocation API to 
      // create new LatLng object with new center
      function getPosition(position) {
        // getting the user's gps position
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;

        // options and settings for map
        var mapOptions = {
          center: new google.maps.LatLng(lat, lng),
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(mapContainer, mapOptions);

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


// creates the google map object inside the #map div
function initMap() {
  // initialising the map's visual settings and theme
  google.maps.visualRefresh = true;
  // retrieving element in DOM where map will be
  var mapElement = document.getElementById("mapContainer");
  getUserPosition(mapElement);
} // end initMap()


ajaxRequest.open("GET", "markers.json");
ajaxRequest.send();

google.maps.event.addDomListener(window, 'load', initMap);