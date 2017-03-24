<?php

  function userExists($service, $id) {
    $query =
      "SELECT * FROM credentials "
      . "WHERE service='$service' "
      . "AND service_id=$id;";

    $rowCount = databaseConnection(function ($db) {
      $result = $db->query($query);
      if (!$result) die("Database Error in userExists function");

      return $result->num_rows;
    });

    return $rowCount > 0;
  }

  function registerUser($name, $email, $service, $serviceID) {
    databaseConnection(function ($db) {

      $sql = "INSERT INTO user (name, email) VALUES ('$name', '$email')";
      if (!$db->query($sql)) die("Could not create user");

      $userID = $db->insert_id;
      $sql = "INSERT INTO credentials (user_id, service, service_id) VALUES ($userID, $service, $serviceID)";
      if (!$db->query($sql)) die("Could not create user credentials");

    });
  }

  function isLoggedIn() {
    return isset($_SESSION['current_user_id']);
  }

  function isCurrentUser($id) {
    return isLoggedIn() && $_SESSION['current_user_id'] == $id;
  }

  function login($service, $id) {
    global $currentUser;

    $_SESSION['current_user_id'] = $userID;

    $currentUser = databaseConnection(function ($db) {
      $query =
        "SELECT * FROM user WHERE id=$userID";

      $result = $db->query($query);
      if (!$result) die("Database Error in userExists function");

      return $result->fetch_assoc();

    });
  }

  function getCurrentUser() {
    global $currentUser;
    return $currentUser;
  }

?>