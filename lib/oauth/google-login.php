<?php

  // Access the google api files
  require_once '/home/pi/Downloads/Google-API/vendor/autload.php';

  //Configure the client object
  $client = new Google_Client();
  $client->setAuthConfig('~/just-play/lib/oauth/client-secret-justplay.json');
  $client->setAccessType("offline");
  $client->setIncludeGrantedScopes(true);
  $client->addScope('profile', 'email', 'openid' );

 ?>
