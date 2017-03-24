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

  function isLoggedIn() {
    return isset($_SESSION['current_user_id']);
  }

  function isCurrentUser($id) {
    return isLoggedIn() && $_SESSION['current_user_id'] == $id;
  }

  function login($userID) {
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