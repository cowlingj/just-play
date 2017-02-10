
function createMap()
{
  var mapProperties=
  {
    center:new google.maps.LatLng(53.467434, -2.233948),
    zoom:15,
    zoomControl: false,
    mapTypeControl: false,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };
  var map=new google.maps.Map(document.getElementById("mapContainer"),
                              mapProperties);
}