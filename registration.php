<?php
    error_reporting(E_ALL & ~E_NOTICE);
    require_once 'master.php'; // Include the necessary dependencies

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Proper password hashing
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        // Check if the email already exists
        $existingUser = $dbHandler->executeSelectQuery("SELECT * FROM tblUser WHERE email = ?", [$email]);

        if ($existingUser) {
            echo "An account with this email already exists.";
        } else {
            // Insert the new user into tblUser
            $insertQuery = "INSERT INTO tblUser (email, password, firstName, lastName, address, phone) VALUES (?, ?, ?, ?, ?, ?)";
            if ($dbHandler->executeQuery($insertQuery, [$email, $hashedPassword, $firstName, $lastName, $address, $phone])) {
                echo "Registration successful!";
                header("Location: login.php");
                exit;
            } else {
                echo "An error occurred during registration.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
</head>
<body>
<div class="container">
    <h2>Create an Account</h2>
    <form method="POST">
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" name="firstName" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" name="lastName" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" name="address" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
</body>
</html>
