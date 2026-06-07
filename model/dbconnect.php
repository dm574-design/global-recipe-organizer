<?php
/*
-----------------------------------------------------------------------------------------------------------------------------------------
Name:        dbconnect.php
Author:      Drew Miller
Date:        2026-03-13
Language:    PHP
Purpose:     The purpose of this file is to establish a PDO connection to the MySQL database
             for use throughout the application.
-----------------------------------------------------------------------------------------------------------------------------------------
ChangeLog:
Who                        When                     What
----------- -------------------- -------------------------------------------------------------------------------------------------------
DNM                        2026-03-13               Original Version
----------------------------------------------------------------------------------------------------------------------------------------
*/

// Database connection parameters
$dsn = 'mysql:host=localhost;dbname=global_recipe_db';
$username = 'SCC';
$password = 'SCC';

// Create PDO connection
try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>Database Connection Error: $error_message</p>";
    exit();
}
?>