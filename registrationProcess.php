<?php

  // "I certify that this submission is my own original work" - Josh Iehle

  require_once 'dblogin.php';

  try {
    $pdo = new PDO($attr, $user, $pass, $opts);
  }
  catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
  }

  function validate_username($field) {
    if ($field == "") {
      return "No Username was entered.<br>";
    }
    else if (strlen($field) < 6) {
      return "Username must contain at least 6 characters.<br>";
    }
    else {
      return "";
    }
  }

  function validate_email($field) {
    if ($field === "") {
      return "No Email was entered.<br>";
    }
    else if (
      !((strpos($field, ".") > 0) &&
      (strpos($field, "@") > 0)) ||
      preg_match("/[^a-zA-Z0-9.@_-]/", $field)
    ) {
      return "Email address is invalid.<br>";
    }
    else {
      return "";
    }
  }

  function validate_password($field) {
    if ($field === "") {
      return "No password was entered.<br>";
    }
    else if (strlen($field) < 8) {
      return "Password must be at least 8 characters.<br>";
    }
    else if (
      !preg_match("/[a-z]/", $field) ||
      !preg_match("/[A-Z]/", $field) ||
      !preg_match("/[0-9]/", $field)
    ) {
      return "Password must contain one of each: a-z, A-Z, and 0-9.<br>";
    }
    else {
      return "";
    }
  }

  function validate_confirm_password($confirmField, $pwdField) {
    return ($confirmField !== $pwdField) ? "Password and Confirm Password fields must match.<br>" : "";
  }

  $username = "";
  $email = "";
  $password = "";
  $confirmPassword = "";

  if (
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password']) &&
    isset($_POST['confirmPassword'])
  ){
    
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);

    $fail = validate_username($username);
    $fail .= validate_email($email);
    $fail .= validate_password($password);
    $fail .= validate_confirm_password($confirmPassword, $password);

    if ($fail === "") {
      $searchIfExistsQuery = "SELECT * FROM users WHERE username = :username";
      $result = $pdo->prepare($searchIfExistsQuery);
      $result->bindParam(':username', $username);
      $result->execute();

      if ($result->rowCount() >= 1) {
        die("Username already exists. Please choose a different username." . "<a href='userRegistrationForm.html'> Try again</a>");
      }
      else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertUserQuery = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($insertUserQuery);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        
        header("Location: login.php");
        echo "Registration successful! You can now log in." . "<a href='login.php'> Log in</a>";
        exit;
      }
    }
    else {
      die($fail . "<br><a href='userRegistrationForm.html'> Try again</a>");
    }
  }

  
?>