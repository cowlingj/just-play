<?php

require('lib/helpers/login/google.php');

function read($pathArgs, $queryArgs, $database) {

  $googleClient = new Google_Client();
  $db = new DB();
  $googleAuth = new GoogleAuth($db, $googleClient);
  $googleAuth->checkRedirectCode();

  header("Location: /mbax4msk/just_play/search-form");

}

?>