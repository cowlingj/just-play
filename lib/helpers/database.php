<?php

  require_once("config.inc.php");

  function databaseConnection($func = NULL) {
    global $database_host, $database_user, $database_pass, $group_dbnames;
    $connection = new mysqli(
      $database_host,
      $database_user,
      $database_pass,
      $group_dbnames[0]
    );

    if ($connection->connect_error)
      die('Connect Error ('.$mysqli->connect_errno.') '.$mysqli->connect_error);
    if (!is_callable($func)) return $connection;
    else {
      $result = $func($connection);
      $connection->close();
      return $result;
    }
  }

?>