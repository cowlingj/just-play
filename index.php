<?php

  // Main entry point for all dynamic content

  // This file will create the database connection object, then send the
  // parameters in the URL, along with the connection, to the method that matches
  // a given route
  require_once("lib/helpers/database.php");
  require_once("lib/secrets.php");
  require_once("conf/routes.php");

  define('PUBLIC_DIRECTORY', "/mbax4msk/just_play/public/assets");

  function layout($name) {
    return "public/layouts/$name.php";
  }

  function controller($name) {
    return "lib/controllers/$name.php";
  }

  function script($name) {
    return "<script src='".PUBLIC_DIRECTORY."/js/$name.js'></script>";
  }

  function style($name) {
    return "<link rel='stylesheet' href='".PUBLIC_DIRECTORY."/css/$name.css' />";
  }

  function main () {

    $router = compileRoutes();
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $res = $router->resolve($_SERVER["REQUEST_METHOD"], $requestPath);
    if ($res["target"] == 404) {
      http_response_code(404);
      require layout("system/client/not-found");
    } else {
      $name = $res["target"];
      $connection = databaseConnection();

      require controller($name);

      $targetFunction = array(
        "POST"    => "create",
        "GET"     => "read",
        "PATCH"   => "update",
        "DELETE"  => "destroy"
      )[$_SERVER["REQUEST_METHOD"]];
      $targetFunction($res["params"], $_GET, $connection);

      $connection->close();
    }

  }

  session_start();
  main();


?>
