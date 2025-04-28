<?php

session_start();

if (isset($_SESSION['username'])) {
  echo "<p class='welcome-msg'>Welcome, " . htmlspecialchars($_SESSION['username']) . "</p>";
  echo "<a class='logout-link' href='logout.php'>Log out</a>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main Menu</title>
  <link rel="stylesheet" href="mainMenu.css">
</head>
<body>
  <!--"I certify that this submission is my own original work" - Josh Iehle-->

  <h1>NFL Player MySQL Database</h1>
  <div class="navigation-menu">
    <h3>Main Menu</h3>
    <div class="navigation-links">
      <a href="listRecords.php" class="link">List Records</a>
      <a href="addRecords.php" class="link">Add Records</a>
      <a href="searchRecords.php" class="link">Search Records</a>
      <a href="deleteRecords.php" class="link">Delete Records</a>
    </div>
  </div>
</body>
</html>