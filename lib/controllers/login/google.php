<?php

require('lib/helpers/login/google.php');
require('lib/helpers/databse.php');
require('lib/helpers/auth.php');

function read($pathArgs, $queryArgs, $database) {

  $googleClient = new Google_Client();
  $db = databaseConnection();
  $googleAuth = new GoogleAuth($db, $googleClient);
  $googleAuth->checkRedirectCode();
  $payload = $googleAuth->getPayload();
  print_r($payload);
  die();
  // Send to databse 

  header("Location: /mbax4msk/just_play/search-form");

}

?>