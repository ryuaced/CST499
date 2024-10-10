<?php
   error_reporting(E_ALL & ~E_NOTICE);
   require 'master.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title> Home Page </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container text-center">
	<h1> Welcome to the Home page</h1>
</div>

<?php require_once 'footer.php';?>
</body>
</html>
<?php
    session_start();
    require_once 'master.php'; // Include session management and database handling

    // Check if the user is already logged in
    if (isset($_SESSION['user_id'])) {
        // Redirect logged-in users to their profile or dashboard
        header("Location: profile.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Welcome to the Course Registration System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>

<div class="container text-center">
    <h1>Welcome to the Online Course Registration System</h1>
    <p>This system allows you to register for courses, manage your profile, and more!</p>

    <div class="row">
        <div class="col-md-6">
            <h2>New Here?</h2>
            <p>If you're a new user, please register to get started.</p>
            <a href="registration.php" class="btn btn-primary btn-lg">Register</a>
        </div>

        <div class="col-md-6">
            <h2>Already Registered?</h2>
            <p>If you already have an account, log in to continue.</p>
            <a href="login.php" class="btn btn-success btn-lg">Log In</a>
        </div>
    </div>
    
    <hr>

    <div class="text-center">
        <p>Looking for more information? Feel free to explore:</p>
        <a href="about.php" class="btn btn-info">About Us</a>
        <a href="contact.php" class="btn btn-info">Contact Us</a>
    </div>
</div>

<?php require 'footer.php'; // Include the footer ?>
</body>
</html>
