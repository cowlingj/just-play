document.addEventListener("DOMContentLoaded", function() {
  var latitude;
  var longitude;

  $(document).ready(function() {
    $(".hidden-allow-location").hide();

    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        function (position) {
          latitude = position.coords.latitude;
          longitude = position.coords.longitude;
        }
      );
    }
  });


  // before the data is sent, get location information from the user
  $(document).submit(function(e) {
    var self = this;
    e.preventDefault();

    var sport = $("select#sport option:selected").attr("value");
    var radius = $("#slider").val();

    $(".hidden-allow-location").slideDown(400);

    if (latitude != null && longitude != null) {
      console.log("dfsh");
      var queryString = "?sport=" + sport + "&radius=" + radius + "&latitude=" + latitude + "&longitude=" + longitude;
      $(location).attr('href', "http://web.cs.manchester.ac.uk/mbax4msk/just_play/response" + queryString);
    }
  });
});