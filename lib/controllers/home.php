<?php

require('lib/helpers/login/facebook.php');
require('lib/helpers/login/google.php');

function read($pathArgs, $queryArgs, $database) {

  $title = "Home | Just Play";
  $text = "Welcome!";

  // Create a GoogleAuth object.
  $db = databaseConnection();
  $googleClient = new Google_Client();
  $auth = new GoogleAuth($db, $googleClient);

  $facebookLoginUrl = getLoginUrl(createFacebookObject()); 

  $googleLoginUrl = $auth->getAuthUrl(); 

  require layout("login");
}

?>
