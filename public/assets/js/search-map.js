// creates the google map object inside the #map div
function initMap(latitude, longitude) {
  // initialising the map's visual settings and theme
  google.maps.visualRefresh = true;
  // retrieving element in DOM where map will be
  var mapElement = document.getElementById("map");
  getUserPosition(mapElement, searchLatitude, searchLongitude);
} // end initMap()

var ajaxRequest = new XMLHttpRequest;
ajaxRequest.open("GET", "/mbax4msk/just_play/markers");
ajaxRequest.send();


google.maps.event.addDomListener(window, 'load', initMap);