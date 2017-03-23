<?php

require('lib/helpers/login/facebook.php');

function read($pathArgs, $queryArgs, $database) {

  $title = "Home | Just Play";
  $text = "Welcome!";

  $loginUrl = getLoginUrl(createFacebookObject()); 

  require layout("login");
}

?>
