<?php
    error_reporting(E_ALL & ~E_NOTICE);
	require 'master.php'; 
	require 'logout_process.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title> Logout Page </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	    <script type="text/javascript">
        // Redirect to login page after 5 seconds
        setTimeout(function(){
            window.location.href = 'login.php';
        }, 5000);
    </script>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>You have been logged out</h1>
        <p>You will be redirected to the login page momentarily.</p>
    </div>
</body>
</html>
