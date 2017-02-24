// function to load the xml generated in order to initiate AJAX 
// url specifies the path to the XML file (or xml php generator)
// callback refers to the function that is called once XML returns to the js
function downloadURL(url, callback) {
  // reference to AJAX request (condition for legacy ie browsers)
  var request = window.ActiveXObject ? 
                new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest;
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    } // end if
  };

  request.open("GET", url, true);
  request.send(null);
} // end downloadURL


// actually calling the function downloadURL() to generate the markers from XML

downloadURL("../../lib/generateXML.php", function (data) {
  var xml = data.responseXML;
  var markers = xml.documentElement.getElementsByTagName("marker");

  // for every marker element
  Array.prototype.forEach.call(markers, function (markerElement) {
    var name = markerElement.getAttribute("name");
    var latitude = markerElement.getAttribute("latitude");
    var longitude = markerElement.getAttribute("longitude");
    // create pin for this marker
    var point = new google.maps.LatLng(
      parseFloat(latitude), parseFloat(longitude)
    );

    // this creates a marker at a given point, with a name
    var marker = new google.maps.Marker({
      lat: latitude,
      lng: longitude,
      label: name
    });
  }
});
