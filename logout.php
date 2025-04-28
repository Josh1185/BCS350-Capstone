<?php

// "I certify that this submission is my own original work" - Josh Iehle

session_start();

if (isset($_SESSION['username'])) {
  // Unset all session variables
  $_SESSION = array();
  setcookie(session_name(), '', time() - 2592000, '/');
  session_destroy();
  header("Location: login.php"); // Redirect to login page
  exit;
}
?>