<?php

public class Markers {

  // holds each marker object inside the n array element
  public $arrayOfMarkers[];

  // create the parent object of the array of objects
  public function __construct(&$markerArray) {
    $arrayCounter = 0;
    // loop through all markers
    foreach ($markerArray as $marker) {
      $this->arrayOfMarkers[$arrayCounter] = $marker;
    } // end loop through all markers
  } // end constructor()

} // end Markers

?>