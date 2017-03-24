<?php
require_once("lib/external/Facebook/autoload.php");
require_once("lib/helpers/database.php");
require_once("lib/helpers/database.php");

define(
  "FACEBOOK_REDIRECT_URI",
  "https://web.cs.manchester.ac.uk/mbax4msk/just_play/login/facebook"
);

function createFacebookObject() {
  return new Facebook\Facebook([
    'app_id' => $GLOBALS['SECRETS']['facebook_app_id'],
    'app_secret' => $GLOBALS['SECRETS']['facebook_app_secret'],
    'default_graph_version' => 'v2.8',
  ]);
}

function getLoginUrl($fb) {
  $permissions = ['email']; // optional
  $helper = $fb->getRedirectLoginHelper();
  return $helper->getLoginUrl(FACEBOOK_REDIRECT_URI, $permissions);
}

function getAccessToken() {
  try {
    if (isset($_SESSION['facebook_access_token'])) {
      return $_SESSION['facebook_access_token'];
    } else {
      return $helper->getAccessToken();
    }
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
}

function exchangeToken(){
   $fb = createFacebookObject();
    echo "checking for access token";
  if (isset($accessToken)) {
      echo "access token found";
    exchangeTokenHelper();
      echo "helper method helped... maybe";
    redirectHeader(); 
      echo "what ever this thing does";
    addFacebookDB();
      echo "i know what your name is ;)";
  } else header ("Location:https://web.cs.manchester.ac.uk/mbax4msk/just_play/");
}

function exchangeTokenHelper() {
  if (isset($_SESSION['facebook_access_token'])) {
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
  } else {
    // getting short-lived access token
    $_SESSION['facebook_access_token'] = (string) $accessToken;
      // OAuth 2.0 client handler
    $oAuth2Client = $fb->getOAuth2Client();
    // Exchanges a short-lived access token for a long-lived one
    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
    $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
    // setting default access token to be used in script
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
  }
}

function redirectHeader() {
  if (isset($_GET['code'])) {
    header('Location: mbax4msk/just_play/public/layouts/search');
  }
}

function addFacebookDB() {
  $db = databaseConnection();
  $profile = getBasicInfo ($fb);
    $id = $profile['id'];
    $name = $profile['name'];
    $email = $profile['email'];
    $db ->query("INSERT INTO user (id, name, email) VALUES ($id, $name,  $email)"); 
    $db->close();
    return $userToDB;
}

function getBasicInfo($fb) {
    try {
    $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
    echo $profile_request['name'];
    die;
    return $profile_request->getGraphNode()->asArray();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    session_destroy();
    // redirecting user back to app login page
    header("Location: /public/layouts/search.php");
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
}
?>
