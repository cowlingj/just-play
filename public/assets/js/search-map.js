// creates the google map object inside the #map div
function initMap() {
  // initialising the map's visual settings and theme
  google.maps.visualRefresh = true;
  // retrieving element in DOM where map will be
  var mapElement = document.getElementById("map");
  getUserPosition(mapElement);
} // end initMap()

/*
ajaxRequest.open("GET", "markers.json");
ajaxRequest.send();
 */

google.maps.event.addDomListener(window, 'load', initMap);