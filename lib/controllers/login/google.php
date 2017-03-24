<?php

require_once('lib/helpers/login/google.php');
require_once('lib/helpers/auth.php');

function read($pathArgs, $queryArgs, $database) {

  $googleClient = new Google_Client();
  $db = databaseConnection();
  $googleAuth = new GoogleAuth($db, $googleClient);

  if ($googleAuth->checkRedirectCode()) {
    $payload = $googleAuth->getPayload();
    $name = null;
    if (isset($payload['name']))
      $name = $payload['name'];
    else
      $name =$payload['email'];

    $email = $payload['email'];
    $id = $payload['sub'];
    
    
    if (!userExists("google", $id))
      registerUser($name, $email, "google", $id);
    
    die("Killed by Melvin");
    login("google", $id);
    header("Location: /mbax4msk/just_play/search-form");

  } 
}

?>