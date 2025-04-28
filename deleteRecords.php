
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Records</title>
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="deleteRecords.css">
  <link rel="stylesheet" href="searchForm.css">
  <link rel="stylesheet" href="tableStyles.css">
</head>
<body>

  <h1>NFL Player MySQL Database</h1>
  <a href="mainMenu.php">Back to Main Menu</a>
  <h2>Search for a Record to Delete</h2>

  <?php
  session_start();
  ?>

  <?php if (isset($_SESSION['username'])): ?>
  <form class="searchForm" action="deleteRecords.php" method="post">
    <label for="searchField">Select a field to search in:</label> <select id="searchField" name="searchField" size="1" required>
                                   <option value="player_id">Player ID</option>
                                   <option value="name">Name</option>
                                   <option value="age">Age</option>
                                   <option value="position">Position</option>
                                   <option value="current_team">Current Team</option>
                                   <option value="draft_year">Draft Year</option>
                                   <option value="college">College</option>
                                 </select>
    <label for="searchValue">Enter a value to search for:</label> <input id="searchValue" name="searchValue" type="text" placeholder="Enter value" required>
                                 <input type="submit" value="Search Record">
  </form>
  <?php endif; ?>
</body>
</html>

<?php

  // "I certify that this submission is my own original work" - Josh Iehle

  if (isset($_SESSION['username'])) {

    require_once 'dblogin.php';

    try {
      $pdo = new PDO($attr, $user, $pass, $opts);
    }
    catch (PDOException $e) {
      throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    if (
      isset($_POST['delete']) &&
      isset($_POST['player_id'])
    ) {

      $idToDelete = htmlspecialchars($_POST['player_id']);
      $deleteQuery = "DELETE FROM players WHERE player_id = :idToDelete";
      $deleteStmt = $pdo->prepare($deleteQuery);
      $deleteStmt->bindParam(':idToDelete', $idToDelete);

      try {
        $deleteStmt->execute();
        echo "<p>Record deleted successfully</p>";
      }
      catch (PDOException $e) {
        echo "<p>Could not delete record. Error: " . $e->getMessage() . "</p>";
      }
      
    }

    if (
      isset($_POST['searchField']) &&
      isset($_POST['searchValue'])
    ) {

      $field = htmlspecialchars($_POST['searchField']);
      $value = htmlspecialchars($_POST['searchValue']);

      if (
        $field == "name" ||
        $field == "current_team" ||
        $field == "college"
      ) {
        $value = "%" . $value . "%";
      }

      $query = "SELECT * FROM players WHERE $field LIKE :value";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':value', $value);
      $stmt->execute();

      if ($stmt->rowCount() >= 1) {

        echo "<h2>" . $stmt->rowCount() . " records found</h2>";
        echo "<div class='recordsToBeDeleted'>";

        while ($row = $stmt->fetch()) {

          $player_id = htmlspecialchars($row['player_id']);
          $name = htmlspecialchars($row['name']);
          $age = htmlspecialchars($row['age']);
          $position = htmlspecialchars($row['position']);
          $current_team = htmlspecialchars($row['current_team']);
          $draft_year = htmlspecialchars($row['draft_year']);
          $college = htmlspecialchars($row['college']);

          echo <<<_END
            <div class="record-container">
              <div class="record">
                <table>
                  <tr> 
                    <th>Player_ID</th> <th>Name</th> <th>Age</th> <th>Position</th> <th>Current Team</th> <th>Draft Year</th> <th>College</th>
                  </tr>
                  <tr>
                    <td> $player_id </td> <td> $name </td> <td> $age </td> <td> $position </td> <td> $current_team </td> <td> $draft_year </td> <td> $college </td>
                  </tr>
                </table>
              </div>

              <form action='deleteRecords.php' method='post'>
                <input type='hidden' name='delete' value='yes'>
                <input type='hidden' name='player_id' value='$player_id'>
                <input type='submit' value='Delete Record'>
              </form>
            </div>
          _END;
        }

        echo "</div>";
      }
      else {
        echo "<h2>No records found</h2>";
      }
    }
  } else {
    echo "<p>You must be logged in to delete records.</p>";
    echo "<a href='login.php'>Log in</a>";
  }

?>