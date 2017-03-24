<?php
echo "this second thing works";
die();
require('lib/helpers/login/facebook.php');
require('lib/helpers/auth.php');

function read($pathArgs, $queryArgs, $database) {
  $fb = createFacebookObject();
  exchangeToken();
  if (!userExists("facebook", $id)) 
    registerUser($name, $email, "facebook", $serviceID);

  login("facebook", $id);
  header("Location: /mbax4msk/just_play/search-form");
}

?>
