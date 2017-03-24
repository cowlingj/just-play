<?php
require('lib/helpers/login/facebook.php');
require('lib/helpers/auth.php');

function read($pathArgs, $queryArgs, $database) {
  $fb = createFacebookObject();
  
  $profile = exchangeToken();
  $name = $profile['name'];
  $email = $profile['email'];
  $serviceID = $profile['id'];
  if (!userExists("facebook", $serviceID)) 
    registerUser($name, $email, "facebook", $serviceID);

  login("facebook", $serviceID);
  header("Location: /mbax4msk/just_play/search-form");
}

?>
