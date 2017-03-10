<?php

// Main entry point for all dynamic content

// This file will create the database connection object, then send the
// parameters in the URL, along with the connection, to the method that matches
// a given route

require_once("../config.inc.php");
require_once("../conf/routes.php");

function layout($name) {
  require("../public/layouts/$name.php");
}

function databaseConnection($host, $user, $pass, $db) {
  $connection = new mysqli($host, $user, $pass, $name);

  if ($connection->connect_error)
    die('Connect Error ('.$mysqli->connect_errno.') '.$mysqli->connect_error);

  return $connection;
}

function main () {

  $router = compileRoutes();
  $res = $router->resolve($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);

  if ($res["target"] == 404) {
    echo 404;
  } else {
    $name = $res["target"];
    $connection = databaseConnection(
      $database_host,
      $database_user,
      $database_pass,
      $group_dbnames[0]
    );

    require("controllers/$name.php");
    switch ($_SERVER["REQUEST_METHOD"]) {
      case "GET": read($res["params"], $_GET, $connection); break;
    }

    $connection->close();
  }

}

main();


?>