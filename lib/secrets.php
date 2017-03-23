<?php

  $connection = databaseConnection(
    $database_host,
    $database_user,
    $database_pass,
    $group_dbnames[0]
  );

  $res = $connection->query("SELECT * FROM app_config");

  if ($res == FALSE)
    die("Could not load application configuration");

  $GLOBALS['SECRETS'] = array_reduce($res->fetch_array(), function ($config, $row) {
    $config[$row[0]] = $row[1];
    return $config;
  }, array());

?>