<?php

  require('lib/helpers/google-oauth/app/init.php');

  class GoogleAuth {

    protected $db;
    protected $client;
    protected $token;

    public function __construct($db, Google_Client $googleClient = null) {

      $this->client = $googleClient;
      $this->db = $db;
      $config = json_decode($GLOBALS['SECRETS']['google_client_secret'], true);

      if($this->client) {

        $this->client->setAuthConfig($config);
        $this->client->setRedirectUri('http://web.cs.manchester.ac.uk/mbax4msk/just_play/login/google');
        $this->client->setScopes('email', 'profile');
      } // if

    } // construct

    public function getAuthUrl() {
      return $this->client->createAuthUrl();
    }

    public function checkRedirectCode() {

      if(isset($_GET['code'])) {

        $this->client->authenticate($_GET['code']);

        $this->setToken($this->client->getAccessToken());

        $this->storeUser($this->getPayload());

        $payload = $this->getPayload();

        return true;
      }
    }

    // get the payload  
    public function getPayload() {
      $payload = $this->client->verifyIdToken();
      return $payload; 
    }

    public function setToken($token) {

      $_SESSION['access_token'] = $token;
      $this->client->setAccessToken($token);

    } // setToken

    protected function storeUser($payload) {
      $sql = "
            INSERT INTO user (profile, email)
            VALUES ('{$payload['profile']}',
                   '{$payload['email']}')
            ";
      $this->db->query($sql);
    }
  } // google auth 

 ?>