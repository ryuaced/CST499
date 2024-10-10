<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require_once 'DatabaseHandler.php'; // Include the DatabaseHandler class

    // Create an instance of DatabaseHandler
    $dbHandler = new DatabaseHandler();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare the SQL query to fetch the user
        $sql = "SELECT * FROM tblUser WHERE email = ?";
        $params = [$email];

        // Execute the query
        try {
            $result = $dbHandler->executeSelectQuery($sql, $params);
            if (count($result) > 0) {
                $user = $result[0];
                if (password_verify($password, $user['password'])) {
                    // Login successful, start session and store user data
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    // Redirect to the profile or dashboard page
                    header("Location: profile.php");
                    exit;
                } else {
                    echo "Password is incorrect!";
                }
            } else {
                echo "Email is incorrect";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid request method!";
    }
?>
