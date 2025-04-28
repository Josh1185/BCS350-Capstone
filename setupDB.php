<?php

  // "I certify that this submission is my own original work" - Josh Iehle

  require_once 'dblogin.php';

  try {
    $pdo = new PDO($attr, $user, $pass, $opts);
  }
  catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
  }

  $createUsersTableQuery = "
    CREATE TABLE IF NOT EXISTS users (
      username VARCHAR(32) NOT NULL UNIQUE,
      email VARCHAR(128) NOT NULL,
      password VARCHAR(255) NOT NULL,
      PRIMARY KEY (username)
    )
  ";

  $createApplicationTableQuery = "
    CREATE TABLE IF NOT EXISTS players (
      player_id SMALLINT AUTO_INCREMENT,
      name VARCHAR(32) NOT NULL,
      age TINYINT NOT NULL,
      position VARCHAR(4) NOT NULL,
      current_team VARCHAR(32) NOT NULL,
      draft_year INT NOT NULL,
      college VARCHAR(32) NOT NULL,
      PRIMARY KEY (player_id),
      CONSTRAINT unique_name_position UNIQUE (name, position)
    )
  "; 
  
  /* UNIQUE constraint ref: https://medium.com/@codesolutionstuff/how-to-use-unique-index-to-prevent-duplicates-in-mysql-8a0553ef0dc#:~:text=index%20in%20MySQL%3F-,The%20UNIQUE%20index%20is%20a%20type%20of%20index%20in%20MySQL,accuracy%20in%20your%20MySQL%20database. */

  /* INSERT IGNORE ref: https://stackoverflow.com/questions/2219786/best-way-to-avoid-duplicate-entry-into-mysql-database#:~:text=You%20can%20set%20the%20PageID,go%20to%20the%20next%20row. */
  
  $insertValuesQuery = "
    INSERT IGNORE INTO players(name, age, position, current_team, draft_year, college) VALUES
      ('Patrick Mahomes', 29, 'QB', 'Chiefs', 2017, 'Texas Tech'),
      ('Lamar Jackson', 28, 'QB', 'Ravens', 2018, 'Louisville'),
      ('Saquon Barkley', 28, 'RB', 'Eagles', 2018, 'Penn State'),
      ('Tyreek Hill', 31, 'WR', 'Dolphins', 2016, 'Oklahoma State'),
      ('Josh Allen', 28, 'QB', 'Bills', 2018, 'Wyoming'),
      ('Joe Burrow', 28, 'QB', 'Bengals', 2020, 'LSU'),
      ('Drake Maye', 22, 'QB', 'Patriots', 2024, 'UNC'),
      ('Jayden Daniels', 24, 'QB', 'Commanders', 2024, 'LSU'),
      ('Jamar Chase', 25, 'WR', 'Bengals', 2021, 'LSU'),
      ('Justin Jefferson', 25, 'WR', 'Vikings', 2020, 'LSU'),
      ('Tee Higgins', 26, 'WR', 'Bengals', 2020, 'Clemson'),
      ('Derrick Henry', 31, 'RB', 'Ravens', 2016, 'Alabama'),
      ('Travis Kelce', 35, 'TE', 'Chiefs', 2013, 'Cincinnati'),
      ('Sauce Gardner', 24, 'CB', 'Jets', 2022, 'Cincinnati'),
      ('Derek Stingley', 23, 'CB', 'Texans', 2022, 'LSU'),
      ('CJ Stroud', 23, 'QB', 'Texans', 2023, 'Ohio State'),
      ('Joe Mixon', 28, 'RB', 'Texans', 2017, 'Oklahoma')
  ";

  try {
    $stmt1 = $pdo->query($createUsersTableQuery);
    $stmt2 = $pdo->query($createApplicationTableQuery);
    $stmt3 = $pdo->query($insertValuesQuery);
    echo "Table 'users' created successfully. <br>";
    echo "Table 'players' created successfully. <br>";
    echo "Table 'players' populated with initial data successfully. <br>";
  }
  catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

?>