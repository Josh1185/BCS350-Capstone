
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Records</title>
  <link rel="stylesheet" href="general.css">
  <link rel="stylesheet" href="form.css">
</head>
<body>

  <h1>NFL Player MySQL Database</h1>
  <a href="mainMenu.php">Back to Main Menu</a>
  <h2>Add Records</h2>

  <?php 
    session_start();
  ?>

  <?php if (isset($_SESSION['username'])): ?>
  <form class="addRecordForm" action="addRecords.php" method="post">
        <div>
        <label for="name">Name</label>
        <input id="name" type="text" name="name" placeholder="First Last" required>
        </div>

        <div>
        <label for="age">Age</label>
        <input id="age" type="number" name="age" min="20" value="20" required>
        </div>

        <div>
        <label for="position">Position</label>
        <input id="position" type="text" name="position" placeholder="QB" required>
        </div>
        
        <div>
        <label for="current_team">Current Team</label>
        <input id="current_team" type="text" name="current_team" placeholder="Team Name" required>
        </div>

        <div>
        <label for="draft_year">Draft Year</label>
        <input id="draft_year" type="number" name="draft_year" min="1960" value="2024" required>
        </div>

        <div>
        <label for="college">College</label>
        <input id="college" type="text" name="college" placeholder="College Name" required>
        </div>

        <input type="submit" value="Add Record">
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
      isset($_POST['name']) &&
      isset($_POST['age']) &&
      isset($_POST['position']) &&
      isset($_POST['current_team']) &&
      isset($_POST['draft_year']) &&
      isset($_POST['college']) 
    ) {
      $name = htmlspecialchars($_POST['name']);
      $age = htmlspecialchars($_POST['age']);
      $position = htmlspecialchars($_POST['position']);
      $current_team = htmlspecialchars($_POST['current_team']);
      $draft_year = htmlspecialchars($_POST['draft_year']);
      $college = htmlspecialchars($_POST['college']);

      $query = "INSERT INTO players(name, age, position, current_team, draft_year, college) 
                VALUES (:name, :age, :position, :current_team, :draft_year, :college)";

      $stmt = $pdo->prepare($query);

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':age', $age);
      $stmt->bindParam(':position', $position);
      $stmt->bindParam(':current_team', $current_team);
      $stmt->bindParam(':draft_year', $draft_year);
      $stmt->bindParam(':college', $college);

      try {
        $stmt->execute([$name, $age, $position, $current_team, $draft_year, $college]);
        echo "<p>Record added successfully</p>";
      }
      catch (PDOException $e) {
        echo "<p>Could not add record. Error: " . $e->getMessage() . "</p>";
      }
    }
  } else {
    echo "<p>You must be logged in to add records.</p>";
    echo "<a href='login.php'>Log in</a>";
  }
  
?>