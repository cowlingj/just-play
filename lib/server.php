<?php

// Main entry point for all dynamic content

// This file will create the database connection object, then send the
// parameters in the URL, along with the connection, to the method that matches
// a given route

// require_once("config.inc.php");
// require_once("../conf/routes.php");

// $router = compileRoutes();

echo $_SERVER["REQUEST_METHOD"]." ".$_SERVER["REQUEST_URI"]."\n";

// $res = $router->resolve($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);

// foreach ($res as $key => $value) {
//   echo "Key: $key; Value: $value\n";
// }


?>