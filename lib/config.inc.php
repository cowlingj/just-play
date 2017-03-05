<?php

$mysql_cnf = parse_ini_file("../../.my.cnf");

$database_host = $mysql_cnf["host"];
$database_user = $mysql_cnf["user"];
$database_pass = $mysql_cnf["password"];
$database_name = $mysql_cnf["database"];
$group_dbnames = array($mysql_cnf["database"]);

?>
