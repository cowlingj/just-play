<?php 

  // Access the google api files
  require_once '~/API/google-api-php-client2.1.1/vendor/autoupload.php';
  
  //Configure the client object
  $client = new Google_Client();
  $client->setAuthConfig('~/just-play/lib/oauth/client-secret-justplay.json');
  $client->setAccessType("offline");
  $client->setIncludeGrantedScopes(true);
  $client->addScope(Google_Sign-In);

 ?>