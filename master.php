<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};

	error_reporting(E_ALL & ~E_NOTICE);
    require_once 'DatabaseHandler.php'; // Include the DatabaseHandler class

    // Create a global instance of DatabaseHandler
    $dbHandler = new DatabaseHandler();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> Master Page </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./Index.php"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="./Index.php">Home</a></li>
                <li><a href="./about.php">About Us</a></li>
                <li><a href="./contact.php">Contact Us</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="./profile.php">Profile</a></li>
                    <li><a href="./logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="./login.php">Login</a></li>
                    <li><a href="./registration.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>
