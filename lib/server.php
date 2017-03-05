<?php

// Main entry point for all dynamic content

// This file will create the database connection object, then send the
// parameters in the URL, along with the connection, to the method that matches
// a given route

include_once("config.inc.php");

$routes = $mysql_cnf = parse_ini_file("../conf/routes.ini");


?>