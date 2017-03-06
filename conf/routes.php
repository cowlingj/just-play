<?php

require_once("../lib/router.php");

function compileRoutes() {
  return new Router()
    
    // Add new routes here. Do not terminate with a semi colon; that is
    // done at the end
    ->addRoute("GET", "/", "home.php")

  ;
}

?>