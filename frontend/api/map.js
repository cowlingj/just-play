// google maps api developer key
// https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9ofPjKpQ3eRwJFOwPgP-BBXgTn9phis

// global variable of map
var map;
// the name initMap is just convention when using the Maps API
function initMap() {
  // initialising the map's visual settings and theme
  google.maps.visualRefresh = true;

  // retrieving element in DOM where map will be
  var mapElement = document.getElementById("map");
  // the content that gets displayed when geoLocation is not supported
  var legacyContainer = document.getElementById("legacy");
  // the content that gets displayed when the user denies geoLocation
  var permissionDeniedContainer = document.getElementById("permission-denied");

  // if GeoLocation API is supported in browser
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

        map = new google.maps.Map(mapElement, mapOptions);

        // initialising an instance of marker to display the user's current location
        var userMarker = new google.maps.Marker({
          position: new google.maps.LatLng(lat, lng),
          map: map
        });

      }, function errorCallback(error) {
        if (error.code == error.PERMISSION_DENIED) {
          permissionDeniedContainer.innerHTML = "You denied location permission, silly!";
        } // end if geoLocation denied
      }
    );
  } else {
    legacyContainer.innerHTML = "You are on a flipping old computer!";
  }// end if (GeoLocation API is supported)
} // end initMap()

// this calls initMap when the page loads
google.maps.event.addDomListener(window, 'load', initMap);