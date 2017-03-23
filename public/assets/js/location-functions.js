// returns a position array containing latitude and longitude
function returnUserLatitude() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        return position.coords.latitude;
      }
    );
  }
} // end returnUserPosition()

var userLatitude

$(document).ready(function() {
  $(".hidden-allow-location").hide();
});



// before the data is sent, get location information from the user
$(document).submit(function(e) {
  var self = this;
  e.preventDefault();

  var sport = $("select#sport option:selected").attr("value");
  var radius = $("#slider").val();

  $(".hidden-allow-location").slideDown(400);

  var latitude;
  var longitude;

  function tryToRedirect() {
    setTimeout(function() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
          }
        );
      } // end if (navigator.geolocation)

      if (latitude != null && longitude != null) {
        var queryString = "?sport=" + sport + "&radius=" + radius + "&latitude=" + latitude + "&longitude=" + longitude;
        $(location).attr('href', queryString);
      } else {
        tryToRedirect();
      }
    }, 2000);

  } // end tryToRedirect()
  
  tryToRedirect();
});