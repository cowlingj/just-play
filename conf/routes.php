<?php
require_once("lib/router.php");

function compileRoutes() {
  $router = new Router();
    
  // Add new routes here
  $router->addRoute("GET", "/", "home");
  // $router->addRoute("GET", "/user/:user", "user");

  // $router->addRoute("GET", "/search", "search");

  // Added by Jonathan
  $router->addRoute("GET", "/search-form", "search");
  $router->addRoute("GET", "/response", "response");
  $router->addRoute("POST", "/response", "response");
  $router->addRoute("GET","/broadcast-request-form","broadcast");
  $router->addRoute("GET","/view-broadcast","view-broadcast");
  $router->addRoute("GET","/request","request");
  $router->addRoute("GET", "/login-with-facebook","login/facebook");
  return $router;
}

?>
