function initMap() {
  var map;
  var desiredLatitude;
  var desiredLongitude;

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      // taking the position reference of user's location 
      // information from the GeoLocation API to 
      // create new LatLng object with new center
      function getPosition(position) {
        var mapOptions = {
          center: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
          zoom: 15,
          mapTypeId: 'hybrid',
          disableDefaultUI: true
        };

        map = new google.maps.Map(document.getElementById("google-map"), mapOptions);

        var previousMarker = new google.maps.Marker({
          position: {lat: position.coords.latitude, lng: position.coords.longitude},
          map: map
        });

        // autofill input boxes onload
        setLatInputValue(previousMarker.position.lat());
        setLngInputValue(previousMarker.position.lng());


        // listen for the user double clicking on the map
        map.addListener("click", function(e) {
          if (previousMarker !== null) {
            previousMarker.setMap(null);
          }

          previousMarker = placeMarkerAndCenter(e.latLng, map);

          // update the input boxes with the pin's position
          setLatInputValue(previousMarker.position.lat());
          setLngInputValue(previousMarker.position.lng());
        });
      }
    );
  }
} // end initAutocomplete()

function placeMarkerAndCenter(latLng, map) {
  var marker = new google.maps.Marker({
    position: latLng,
    map: map
  });

  map.panTo(latLng);
  return marker;       
} // end placeMarkerAndCenter()


function setLatInputValue(newLatitude) {
  $("input#latitude").val(newLatitude);
} // end setLatInputValue()

function setLngInputValue(newLongitude) {
  $("input#longitude").val(newLongitude);
}


google.maps.event.addDomListener(window, 'load', initMap);