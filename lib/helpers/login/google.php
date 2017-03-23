<?php 

  require_once '/home/pi/Downloads/Google-API/vendor/autoload.php';

  function init(){

  setAuthConfig( '/home/pi/oauth/oauth/client_secret_justplay.json');
  setRedirectUri('http://web.cs.manchester.ac.uk/mbax4msk/just_play/');
  setScopes('email');
    
  } // init


    public function isLoggedIn() {
      return isset($_SESSION['access_token']);
    }

    public function getAuthUrl() {
      return createAuthUrl();
    }

    public function checkRedirectCode() {

      if(isset($_GET['code'])) {

        authenticate($_GET['code']);

        setToken(setAccessToken());

        storeUser(getPayload());

        $payload = getPayload();

        return true;
      } // if 
    } // checkRedirectCode

      // get the payload  
    public function getPayload() {
      $token = verifyIdToken()->getAttributes()['payload'];
      return $token; 
    } // getPayload

    public function setToken($token) {

      $_SESSION['access_token'] = $token;
      setAccessToken($token);

    } // setToken

    protected function storeUser($payload) {
      $sql = "
            INSERT INTO user (id, name, email)
            VALUES ({$payload['id']}, '{$payload['name']}',
                   '{$payload['email']}')
            ON DUPLICATE KEY UPDATE id = id
            ";
      $this->db->query($sql);
    }

    public function logout() {
      unset($_SESSION['access_token']);
    } // logout


  } // GoogleAuth

 ?>