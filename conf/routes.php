<?php

require_once("../lib/router.php");

function compileRoutes() {
  $router = new Router();
    
  // Add new routes here
  $router->addRoute("GET", "/", "home.php");

  return $router;
}

?>