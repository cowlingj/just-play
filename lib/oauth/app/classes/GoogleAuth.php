<?php 

  class GoogleAuth {

    protected $db;
    protected $client;

    public function _construct(DB $db = null,Google_Client $googleClient = null) { 

      $this->client = $googleClient;
      $this->db = $db;

      if($this->client) { 
        $this->client->setClientId('759163150676-gs3pf51hrk7cvfo9bgnmcg66uomk01ak.apps.googleusercontent.com ');
        $this->client->setClientSecret('tmDaqddoAVDSXB4hN1DT6raH');
        $this->client->setRedirectUri('localhost/tutorial/oauth/index.php');
        $this->client->setScopes('email');
      } // if

    } // construct

    public function isLoggedIn() {
      return isset($_SESSION['access_token']);
    }

    public function getAuthUrl() {
      return $this->client->createAuthUrl();
    }

    public function checkRedirectCode() {
      if(isset($_get['code'])) {
        $this->client->authenticate($_GET['code']);  

        $this->setToken($this->client->getAccessToken());

        return true;
      }
    }

    public function setToken($token) {

      $_SESSION['access_token'] = $token;
      $this->client->setAccessToken($token);

    } // setToken

    public function logout() {
      unset($_SESSION['access_token']);
    } // logout

  } // Googleauth 
  
 ?>