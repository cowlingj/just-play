<?php

// Main entry point for all dynamic content

// This file will create the database connection object, then send the
// parameters in the URL, along with the connection, to the method that matches
// a given route

require_once("../config.inc.php");
require_once("../conf/routes.php");

$router = compileRoutes();

$res = $router->resolve($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);

if ($res["target"] == 404) {
  echo 404;
} else {
  echo "found";
}


?>