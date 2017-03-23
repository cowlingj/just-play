<?php

require('lib/helpers/login/facebook.php');

function read($pathArgs, $queryArgs, $database) {

  exchangeToken();
  header("Location: /mbax4msk/just_play/search-form");

}

?>
