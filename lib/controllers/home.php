<?php

require 'lib/index.php';

function read($pathArgs, $queryArgs, $database) {

  $title = "Home | Just Play";
  $text = "Welcome!";
  global $loginUrl;
  $loginUrl = "poo";

  require layout("login");
}

?>
