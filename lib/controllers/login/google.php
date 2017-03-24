<?php

require('lib/helpers/login/google.php');

function read($pathArgs, $queryArgs, $database) {

  $googleClient = new Google_Client();
  $googleClient->checkRedirectCode();

  header("Location: /mbax4msk/just_play/search-form");

}

?>