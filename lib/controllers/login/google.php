<?php

require_once('lib/helpers/login/google.php');
require_once('lib/helpers/auth.php');

function read($pathArgs, $queryArgs, $database) {

  $googleClient = new Google_Client();
  $db = databaseConnection();
  $googleAuth = new GoogleAuth($db, $googleClient);
  if ($googleAuth->checkRedirectCode()) {
    print_r($payload);
    die();
    header("Location: /mbax4msk/just_play/search-form");
  } 
}

?>