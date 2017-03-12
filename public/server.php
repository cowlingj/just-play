<?php

// Main entry point for all dynamic content

// This file will create the database connection object, then send the
// parameters in the URL, along with the connection, to the method that matches
// a given route

require_once("../config.inc.php");
require_once("../conf/routes.php");

define('PUBLIC_DIRECTORY', "/mbax4msk/just_play/public");
$title = "Just Play";

function layout($name) {
  return "../public/layouts/$name.php";
}

function controller($name) {
  return "controllers/$name.php";
}

function script($name) {
  return "<script src='".PUBLIC_DIRECTORY."/scripts/$name.js'></script>";
}

function style($name) {
  return "<link rel='stylesheet' href='".PUBLIC_DIRECTORY."/styles/$name.css' />";
}

function databaseConnection($host, $user, $pass, $db) {
  $connection = new mysqli($host, $user, $pass, $db);

  if ($connection->connect_error)
    die('Connect Error ('.$mysqli->connect_errno.') '.$mysqli->connect_error);

  return $connection;
}

function main () {

  echo implode(", ", scandir($_SERVER['DOCUMENT_ROOT']."/mbax4msk/just_play"));
  // config.inc.php declares variables in the global scope
  global $database_host, $database_user, $database_pass, $group_dbnames;
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

    require controller($name);

    switch ($_SERVER["REQUEST_METHOD"]) {
      case "POST":    create($res["params"], $_GET, $connection);   break;
      case "GET":     read($res["params"], $_GET, $connection);     break;
      case "PATCH":   update($res["params"], $_GET, $connection);   break;
      case "DELETE":  destroy($res["params"], $_GET, $connection);  break;
    }

    $connection->close();
  }

}

main();


?>