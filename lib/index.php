<?php
session_start();
require_once __DIR__ . 'lib/src/Facebook/autoload.php';


$fb = new Facebook\Facebook([
  'app_id' => '422280014788952',
  'app_secret' => '2fdac2ba66c2c991c7a7bc2dfa9a80a3',
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // optional
	
try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
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

if (isset($accessToken)) {
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

	// redirect the user back to the same page if it has "code" GET variable
	if (isset($_GET['code'])) {
		header('Location: ./');
	}

	// getting basic info about user
	try {
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
		$profile = $profile_request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	// printing $profile array on the screen which holds the basic info about user
	//print_r($profile);
	print("<br />");
	print($profile["name"]);
	print("<br />");
	print($profile["email"]);
	print("<br />");
	print($profile["id"]);
	print("<br />");
        print("karan is a php g");

require_once('config.inc.php');

// Connect to the database
$mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);

// Check for errors before doing anything else
if($mysqli -> connect_error) {
    die('Connect Error ('.$mysqli -> connect_errno.') '.$mysqli -> connect_error);
}


$profile_name = $profile["name"];
$profile_email = $profile["email"];

$sql = 

//INSERT INTO Delegates ([MemNo],[FromYr],[ToYr]) values(@MemNo, @FromYr,@ToYr)
//where @MemNo not in 
//(
 //   SELECT MemNo FROM words WHERE FromYr = @FromYr
//)

"INSERT INTO database (name, email) VALUES ('$profile_name', '$profile_email')";
mysqli_query($mysqli, $sql);
mysqli_close($mysqli);



  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl('https://web.cs.manchester.ac.uk/mbyxakk2/testing/index.php', $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}
?>
