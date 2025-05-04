# BCS350-Capstone
A dynamic web database application created with PHP for server-side, HTML for basic structure, CSS for styling, JavaScript for client-side validation, and MySQL for the database.

Demo Video: https://youtu.be/oFdZbjP5P4g 

Development Stack:
- XAMPP

Database Design:
- The database is an NFL player database, and it contains two tables, which are ‘players’ and ‘users’

- ‘players’ contains data about each player in 7 columns: player_id, name, age, position, current_team, draft_year, and college.

- ‘users’ contains data about each authorized user for the application itself in 3 columns: username, email, and password.

- The primary key for ‘players’ is player_id and it is auto incremented.
  
- The ‘players’ table has a unique constraint for two columns (name, position) to ensure that no duplicate rows are inserted.

- The primary key for ‘users’ is username.

FILES:

dblogin.php:
- Contains the database connection configuration settings that are used to connect to the MySQL database using PDO

setupDB.php:
- Creates the ‘players’ table, which stores the data for each NFL player. Creates the ‘users’ table, which is used for storing user account information for the application.
- A unique constraint is established in the ‘players’ table to ensure that there are no duplicate player name-position pairs. 
- Populates the ‘players’ table with a set of predefined records using INSERT IGNORE to avoid duplicates.

mainMenu.php:
- Serves as the main menu for the web application. It starts a session and, if the user is logged in, displays a welcome message and a link to logout. The HTML section provides navigation to the four main features of the app: listing, adding, searching, and deleting player records.
![image](https://github.com/user-attachments/assets/9c538ab8-44e6-4060-a50d-9c54b5c5b150)


listRecords.php:
- Displays all records from the database to users who are logged-in. 
- It first checks if the user is logged in via session, then connects to the database using the configurations from dblogin.php. If the connection is successful, it queries all records from the ‘players’ table and displays them in an HTML table (All output is sanitized). If there are no records in the table, it shows an appropriate message. If the user is not logged in, they are unable to view the records, and a login link is provided. Navigation back to the main menu is also included.
![image](https://github.com/user-attachments/assets/10a24bb5-0555-4e42-822f-bb457f05f9c1)


addRecords.php:
- Allows logged-in users to add new player records to the database.
- It displays an HTML form with fields for name, age, position, team, draft year, and college. Upon submission, the input data is validated, sanitized, and inserted into the ‘players’ table using prepared statements to ensure security. This file ensures that only an authorized user can access the form and insert data, and it provides feedback on whether or not the insertion was successful. Users who are not logged-in are prompted to login first.
![image](https://github.com/user-attachments/assets/e1b379f1-f03e-432d-b708-65740e4ce404)


searchRecords.php:
- Allows logged-in users to search for a record by selecting a field via a dropdown and entering a search value in an HTML form. 
- Prepared statements are used to securely search the ‘players’ table, supporting partial matches for the text fields via the use of wildcard characters. Records that match the search criteria are sanitized and displayed in an HTML table. Users who are not logged-in are prompted to login first.
![image](https://github.com/user-attachments/assets/d4b03f77-158b-454e-86be-3137d1fb6fb2)


deleteRecords.php:
- Allows logged-in users to search for records (Similar to the searchRecords.php functionality) and delete them from the database.
- The HTML search form is identical to the one in the searchRecords.php file. Records that match the search criteria are sanitized, and each one is displayed with a delete button that allows the user to remove a specific record from the database. The delete functionality uses prepared statements to ensure security, and success or error messages are shown after execution of the query. Users who are not logged-in are prompted to login first.
![image](https://github.com/user-attachments/assets/0e61df11-a0c7-4f42-babe-1ade76e7d8f1)


userRegistration.html:
- Displays a form that allows for registration of new users; it contains fields for a username, email, password, and password confirmation. The form has client-side validation via the use of JavaScript to ensure all fields meet the specific criteria before submission to the server. If all input data is valid, the form is submitted to registrationProcess.php and is processed on the server-side. A login link is provided for users who already have an account.

registrationProcess.php:
- Processes the user registration input from the registration form after submission and performs server-side validation.
- It checks if the username entered already exists in the database, ensures that all validation criteria is checked before further processing. If all validations successfully pass, the password is salted and hashed, and the user’s data is submitted to the ‘users’ table in the database. If the username is already taken or any validation fails, an error message is shown and the user is prompted to fix the input. If registration is successful, the user is redirected to the login page.

login.php:
- Implements a secure login system for the application. The input data is validated on the client-side using JavaScript and the server-side using PHP. The provided input data is then checked against the stored users in the database. If the credentials are valid and match an entry in the database, a secure session is started, and the user is redirected to the main menu. If authentication fails, appropriate error messages are displayed.

logout.php:
- Handles user logout functionality. When accessed, it checks if a session is active by verifying if a username is set in the session. If so, all session variables are cleared, the session cookie is deleted, the session is destroyed, and then the user is redirected to the login page. This file ensures that the user is fully logged out and prevents any unauthorized access through an existing session.

general.css:
- Handles all general styles including body styles, header styles, paragraph styles, and hyperlink styles.

form.css: 
- Handles the styles for the login, registration, and add records form.

mainMenu.css:
- Handles the styles for the main menu page.

tableStyles.css:
- Handles the styles for the tables that display the records. This form of styling is used for the list records and search records module.

searchForm.css:
- Handles the styles for the form used to search for records in the search records and delete records module.

deleteRecords.css:
- Handles the styles for the way records are displayed in the search results of the delete records module. This differs from the tableStyles.css because each row needed its own delete button associated with it.
