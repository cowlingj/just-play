<?php 

  require_once 'lib/google-api/vendor/autoload.php';

  function init(){

  setAuthConfig( 'lib/helpers/google-oauth');
  setRedirectUri('http://web.cs.manchester.ac.uk/mbax4msk/just_play/');
  setScopes('email');
    
  } // init


    function isLoggedIn() {
      return isset($_SESSION['access_token']);
    }

    function getAuthUrl() {
      return createAuthUrl();
    }

    function checkRedirectCode() {

      if(isset($_GET['code'])) {

        authenticate($_GET['code']);

        setToken(setAccessToken());

        storeUser(getPayload());

        $payload = getPayload();

        return true;
      } // if 
    } // checkRedirectCode

      // get the payload  
    function getPayload() {
      $token = verifyIdToken()->getAttributes()['payload'];
      return $token; 
    } // getPayload

    function setToken($token) {

      $_SESSION['access_token'] = $token;
      setAccessToken($token);

    } // setToken

    function storeUser($payload) {
      $sql = "
            INSERT INTO user (id, name, email)
            VALUES ({$payload['id']}, '{$payload['name']}',
                   '{$payload['email']}')
            ON DUPLICATE KEY UPDATE id = id
            ";
    }

    function logout() {
      unset($_SESSION['access_token']);
    } // logout

 ?>