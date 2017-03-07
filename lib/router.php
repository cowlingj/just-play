<?php

// Class representing a route segment

class RouteNode {
  // The name given to the node
  private $id;

  // An array of all the other paths from this node
  private $paths = array();

  // True if the segment should be treated as a parameter
  private $isParameter;

  // Stores the next parameter node for this node
  private $nextParameter;

  // Target file
  private $target;

  function __construct($segment, $file = FALSE) {
    // Parameters have a leading colon
    if ($segment[0] == ':') {
      $this->isParameter = true;
      $segment = substr($segment, 1);
    } else $this->isParameter = true;

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
      if ($this->paths[$segment]) {
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
      if ($this->target) die("Target for ".$this->id." already set");
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
        $params[$this->nextParameter->$id] = $segment;
        // And follow the path
        return $this->nextParameter->resolve($rest, $params);
      }
    }

    // If all else fails, we say we can't find it
    return array("target"=>404, "params"=>$params);
  }
}


class Router {
  
  private $routes = array();

  public function addRoute($method, $uri, $target) {
    if (!is_array($this->routes)) $this->routes = array();
    $route = explode("/", $uri);
    $node = NULL;
    if (array_key_exists($method, $this->routes)) {
      $node = $this->routes[$method];
    } else {
      $this->routes[$method] = $node = new RouteNode($method);
    }
    $node->addRoute($route, $target);
    return $this;
  }

  public function resolve($method, $uri) {
    if (!is_array($this->routes)) $this->routes = array();
    $route = explode("/", $uri);
    if (array_key_exists($method, $this->routes)) {
      return $this->routes[$method]->resolve($route, array());
    } else {
      return array("target"=>404, "params"=>array());
    }
  }

}

?>