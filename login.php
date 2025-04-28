<?php

// "I certify that this submission is my own original work" - Josh Iehle

// I had some help from the following source: https://youtu.be/5L9UhOnuos0?si=LvK6mVljDvrrKZLW

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

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = htmlspecialchars($_POST['username']);
    $tempPassword = htmlspecialchars($_POST['password']);

    $fail = validate_username($username);
    $fail .= validate_password($tempPassword);

    if ($fail === "") {
      $query = "SELECT * FROM users WHERE username = :username";
      $result = $pdo->prepare($query);
      $result->bindParam(':username', $username);
      $result->execute();

      $user = $result->fetch(PDO::FETCH_ASSOC);
      if ($user) {

        if (password_verify($tempPassword, $user['password'])) {

          session_start();
          session_regenerate_id(); // Regenerate session ID to prevent session fixation attacks
          $_SESSION['username'] = $user['username'];
          header("Location: mainMenu.php"); // Redirect to user home page
          exit;
        } 
        else {
          echo "<p>Incorrect username or password. Please try again.</p>";
        }
      }
      else {
        echo "<p>Incorrect username or password. Please try again.</p>";
      }
    }
    else {
      die($fail . "<br><a href='login.php'> Try again</a>");
    }
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="form.css">
  <link rel="stylesheet" href="general.css">
  <script>

    function validate(form) {
      let fail = "";

      fail = validateUsername(form.username.value);
      fail += validatePassword(form.password.value);

      if (fail === "") {
        return true;
      } else {
        alert(fail);
        return false;
      }
    }

    function validateUsername(field) {
      if (field === "") {
        return "No Username was entered.\n";
      }
      else if (field.length < 6) {
        return "Username must contain at least 6 characters.\n";
      } 
      else {
        return "";
      }
    }

    function validatePassword(field) {
      if (field === "") {
        return "No Password was entered.\n";
      }
      else if (field.length < 8) {
        return "Password must be at least 8 characters.\n";
      }
      else if (
        !/[a-z]/.test(field) ||
        !/[A-Z]/.test(field) ||
        !/[0-9]/.test(field)
      ) {
        return "Password must contain one of each: a-z, A-Z, and 0-9.\n";
      }
      else {
        return "";
      }
    }

  </script>
</head>
<body>
  <h1>Login</h1>

  <form action="login.php" method="POST" onsubmit="return validate(this)">
    <div>
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Enter username">
    </div>
    <div>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter password">
    </div>
    <p class="register-link" >No account? <a href="userRegistrationForm.html">Register</a></p>
    <input type="submit" value="Login">
  </form>
</body>
</html>