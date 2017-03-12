<?php

function read($pathArgs, $queryArgs, $database) {
  global $title, $text;

  $title = "Home | Just Play";
  $text = "Welcome!";

  layout("home");
}

?>