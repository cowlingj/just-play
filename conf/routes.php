<?php

require_once("../lib/router.php");

function compileRoutes() {
  $router = new Router();
    
  // Add new routes here
  $router->addRoute("GET", "/", "home");
  $router->addRoute("GET", "/user/:user", "user");
  $router->addRoute("GET", "/search", "search");

  return $router;
}

?>