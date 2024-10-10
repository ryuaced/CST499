<?php
require_once 'databasehandler.php'; // Ensure the path to your DatabaseHandler.php is correct

try {
    // Instantiate the DatabaseHandler to test the connection
    $dbHandler = new DatabaseHandler();
    echo "Database connection successful!";
} catch (Exception $e) {
    // Display the connection error
    echo "Error: " . $e->getMessage();
}
?>
