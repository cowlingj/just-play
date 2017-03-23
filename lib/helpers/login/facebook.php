<?php
require_once("lib/external/Facebook/autoload.php");

define(
  "FACEBOOK_REDIRECT_URI",
  "https://web.cs.manchester.ac.uk/mbax4msk/just_play/login/facebook"
);


function getLoginUrl() {
  $fb = new Facebook\Facebook([
    'app_id' => $SECRETS['facebook_app_id'],
    'app_secret' => $SECRETS['facebook_app_secret'],
    'default_graph_version' => 'v2.8',
    ]);
  $permissions = ['email']; // optional
  $helper = $fb->getRedirectLoginHelper();
  return $helper->getLoginUrl(FACEBOOK_REDIRECT_URI, $permissions);
}

?>
