<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Records</title>
  <link rel="stylesheet" href="tableStyles.css">
  <link rel="stylesheet" href="general.css">
</head>
<body>
  <h1>NFL Player MySQL Database</h1>
  <a href="mainMenu.php">Back to Main Menu</a>
</body>
</html>

<?php

  // "I certify that this submission is my own original work" - Josh Iehle

  session_start();

  if (isset($_SESSION['username'])) {

    require_once 'dblogin.php';

    try {
      $pdo = new PDO($attr, $user, $pass, $opts);
    }
    catch (PDOException $e) {
      throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    try {
      $query = "SELECT * FROM players";
      $result = $pdo->query($query);

      if ($result->rowCount() >= 1) {

        echo "<h2>Displaying all " . $result->rowCount() . " records</h2>";

        echo "<div class='table-wrapper'>";
        echo "<table><tr> <th>Player_ID</th> <th>Name</th> <th>Age</th> <th>Position</th> <th>Current Team</th> <th>Draft Year</th> <th>College</th></tr>";
      
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
          echo "<tr>";
          for ($col = 0; $col <= 6; ++$col)
            echo "<td>" . htmlspecialchars($row[$col]) . "</td>";
          echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
      }
      else {
        echo "<h2>No records to display</h2>";
      }
    }
    catch (PDOException $e) {
      echo "<p>Error: " . $e->getMessage() . "</p>";
    }

  } else {
    echo "<p>You must be logged in to view records.</p>";
    echo "<a href='login.php'>Log in</a>";
  }
?>