<?php

  require('lib/helpers/google-oauth/app/init.php');

  class GoogleAuth {

    protected $db;
    protected $client;
    protected $token;

    public function __construct(DB $db = null, Google_Client $googleClient = null) {

      $this->client = $googleClient;
      $this->db = $db;

      if($this->client) {

        $this->client->setAuthConfig('/home/pi/oauth/oauth/client_secret_justplay.json');
        $this->client->setRedirectUri('http://web.cs.manchester.ac.uk/mbax4msk/just_play/');
        $this->client->setScopes('email');
      } // if

    } // construct

    public function getAuthUrl() {
      return $this->client->createAuthUrl();
    }

    public function checkRedirectCode() {
      if(isset($_GET['code'])) {

        $this->client->authenticate($_GET['code']);

        $this->setToken($this->client->setAccessToken());

        $this->storeUser($this->getPayload());

        $payload = $this->getPayload();

        return true;
      }
    }

    // get the payload  
    public function getPayload() {
      $token = $this->client->verifyIdToken()->getAttributes()['payload'];
      return $token; 
    }

    public function setToken($token) {

      $_SESSION['access_token'] = $token;
      $this->client->setAccessToken($token);

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
  } // google auth 

 ?>