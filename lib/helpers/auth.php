<?php

  function userExists($service, $id) {
    $query =
      "SELECT * FROM credentials "
      . "WHERE service='$service' "
      . "AND service_id=$id;";

    $rowCount = databaseConnection(function ($db) use ($service, $id, $query) {
      $result = $db->query($query);
      if (!$result) die("Database Error in userExists function");
    
      return $result->num_rows;
    });

    return $rowCount > 0;
  }

  function registerUser($name, $email, $service, $serviceID) {
    databaseConnection(function ($db) use ($name, $email, $service, $serviceID){

      $sql = "INSERT INTO user (name, email) VALUES ('$name', '$email')";
      if (!$db->query($sql)) {
        echo "Error: ".$db->error."<br>";
        die("Could not create user");
      }

      $userID = $db->insert_id;
      $sql = "INSERT INTO credentials (user_id, service, service_id) VALUES ($userID, '$service', '$serviceID')";
      if (!$db->query($sql)){
        echo "Error: ".$db->error."<br>";
        die("Could not create user credentials");
      }

    });
  }

  function isLoggedIn() {
    print_r($_SESSION['current_user_id']);
    return isset($_SESSION['current_user_id']);
  }

  function isCurrentUser($id) {
    return isLoggedIn() && $_SESSION['current_user_id'] == $id;
  }

  function login($service, $id) {
    global $currentUser;

    $currentUser = databaseConnection(function ($db) use ($service, $id) {
      $query =
        "SELECT * FROM credentials WHERE service='$service' AND service_id='$id'";

      $result = $db->query($query);
      if (!$result) die("Database Error in login");

      $credentials = $result->fetch_assoc();
      $query =
        "SELECT * FROM user WHERE id='".$credentials['user_id']."'";

      $result->free();
      $result = $db->query($query);
      if (!$result) die("Database Error in login (getting user)");

      return $result->fetch_assoc();

    });

    $_SESSION['current_user_id'] = $currentUser['id'];

  }

  function getCurrentUser() {
    global $currentUser;
    
    if (!is_array($currentUser))
      $currentUser = databaseConnection(function ($db) {
        $id = $_SESSION['current_user_id'];
        $query =
          "SELECT * FROM user WHERE id='$id'";

        $result = $db->query($query);
        if (!$result) {
          echo "Error: ".$db->error."<br>";
          die("Database Error in login (getting current user)");
        }

        return $result->fetch_assoc();

      });
    
    return $currentUser;
  }

?>