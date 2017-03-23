<?php 

  require_once 'app/init.php';

  $auth = new GoogleAuth();

  $auth->logout();

  header('location: index.php');
 ?>