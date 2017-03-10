<?php

// Class representing a route segment
// 
// Think of the routing system as a tree
// Each segment in a URI is represented by a tree node.
// The Router will step through each node recursively untill it reaches
// a terminal node. If that node has no targer i.e doesn't point
// to a controller, then it returns 404. If a node doesn't have a
// child node for a particular segment, it also returns a 404

class RouteNode {
  // The name given to the node
  private $id;

  // An array of all the other paths from this node
  private $paths = array();

  // True if the segment should be treated as a parameter
  private $isParameter;

  // Stores the next parameter node for this node
  private $nextParameter = NULL;

  // Target file
  private $target = NULL;

  function __construct($segment, $file = FALSE) {

    if (empty($segment)) die("Each node requires a name");
    // Parameters have a leading colon
    if ($segment[0] == ':') {
      $this->isParameter = TRUE;
      $segment = substr($segment, 1);
    } else $this->isParameter = FALSE;

    $this->id = $segment;
    $this->target = $file;

  }

  private function addNode($segment) {
    $node = new RouteNode($segment);
    if ($node->isParameter) {
      // We can only have one parameter per node
      // The parameter that is already there takes priority
      if ($this->nextParameter == NULL) {
        $this->nextParameter = $node;
      } else die("Next parameter already set for segment ".$this->id);
    } else {
      // We cannot overwite segments
      if (isset($this->paths[$segment])) {
        die("Path $segment already set for segment ".$this->id);
      } else {
        $this->paths[$segment] = $node;
      }
    }
    return $node;
  }

  public function addRoute($route, $file) {
    // If there are no more segments to follow
    if (count($route) == 0) {
      // We cannot overwrite targets
      if ($this->target != NULL) die("Target for ".$this->id." already set");
      else $this->target = $file;
    } else {
      // Create the node. The new node is returned to us
      $this->addNode($route[0])->addRoute(array_slice($route, 1), $file);
    }
  }

  public function resolve($route, $params) {
    // If therer are no more segments to consider
    if (count($route) == 0) {
      // And we have a target file
      if ($this->target)
        return array("target"=>$this->target, "params"=>$params);
    } else {
      // The head of the array will be considered
      $segment = $route[0];
      $rest = array_slice($route, 1);

      // If we have a path with the given segment name
      if (array_key_exists($segment, $this->paths)) {
        // We follow that path
        return $this->paths[$segment]->resolve($rest, $params);
      } 
      // If not, it may be a parameter
      else if ($this->nextParameter) {
        // We store the parameter
        $params[$this->nextParameter->id] = $segment;
        // And follow the path
        return $this->nextParameter->resolve($rest, $params);
      }
    }

    // If all else fails, we say we can't find it
    return array("target"=>404, "params"=>$params);
  }
}

// The router itself

class Router {
  
  // An array of nodes for HTTP Methods, which represent the start of a route
  private $routes;

  function __construct() {
    $this->routes = array();
  }

  public function addRoute($method, $uri, $target) {
    // Split the uri into an array of segments, filtering out empty strings
    $route = array_values(array_filter(explode("/", $uri)));
    // Check if the node for a route exists
    $node = array_key_exists($method, $this->routes)
      ? $this->routes[$method]
      : $this->routes[$method] = new RouteNode($method)
    ;
    // array_filter causes the array to contain an empty string if the uri is
    // '/'. We reference this as the root of the app
    if (count($route) == 0) {
      $route = array('@root');
    }
    $node->addRoute($route, $target);
    return $this;
  }

  public function resolve($method, $uri) {
    // We slice te first two segments off because they will be
    // <username> and 'just-play'
    $route = array_values(array_filter(array_slice(explode("/", $uri), 3)));
    if (count($route) == 0) $route = array('@root');
    echo "Resolving ".$uri;
    return array_key_exists($method, $this->routes)
      ? $this->routes[$method]->resolve($route, array())
      : array("target"=>404, "params"=>array())
    ;
  }

}

?>