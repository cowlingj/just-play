<?php

require('lib/helpers/login/facebook.php');

function read($pathArgs, $queryArgs, $database) {

  $title = "Home | Just Play";
  $text = "Welcome!";


  $facebookLoginUrl = getLoginUrl(createFacebookObject()); 

  // $googleLoginUrl = getAuthUrl(); 

  require layout("login");
}

?>
