<?php
require_once("lib/external/Facebook/autoload.php");

define("FACEBOOK_REDIRECT_URI", "http://web.cs.manchester.ac.uk/mbax4msk/just_play/");

$fb = new Facebook\Facebook([
  'app_id' => '422280014788952',
  'app_secret' => '2fdac2ba66c2c991c7a7bc2dfa9a80a3',
  'default_graph_version' => 'v2.8',
  ]);
$permissions = ['email']; // optional


function getLoginUrl() {
  global $fb, $permissions;
  $helper = $fb->getRedirectLoginHelper();
	return $helper->getLoginUrl(FACEBOOK_REDIRECT_URI, $permissions);
}

?>
