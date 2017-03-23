<?php

public class Marker {

  public $broadcaster;
  public $longitude;
  public $latitude;

  // constructor method
  public function __construct($broadcaster, $location) {
    $this->broadcaster = $broadcaster;

    // connect to the database and get the location row that is relevant to the given location
    $locationInformation = retrieveBroadcastLocation($location);
    $this->latitude = $locationInformation["latitude"];
    $this->longitude = $locationInformation["longitude"];
  } // end constructor method

} // end Marker

?>