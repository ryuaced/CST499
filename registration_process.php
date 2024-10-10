<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require_once 'DatabaseHandler.php'; // Include the DatabaseHandler class

    $dbHandler = new DatabaseHandler();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $email = $_POST['email'];
        $password = $_POST['password'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $checkEmailQuery = "SELECT * FROM tblUser WHERE email = ?";
        $existingUser = $dbHandler->executeSelectQuery($checkEmailQuery, [$email]);

        if ($existingUser) {
            echo "An account with this email already exists.";
        } else {
            // Insert the new user into the tblUser
            $insertQuery = "INSERT INTO tblUser (email, password, firstName, lastName, address, phone) VALUES (?, ?, ?, ?, ?, ?)";
            $params = [$email, $hashedPassword, $firstName, $lastName, $address, $phone];
            
            try {
                $dbHandler->executeQuery($insertQuery, $params);
                echo "Registration successful!";
                header("Location: login.php");
                exit;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    } else {
        echo "Invalid request method!";
    }
?>
