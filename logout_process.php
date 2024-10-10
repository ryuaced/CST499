<?php
    error_reporting(E_ALL & ~E_NOTICE);
    // Start session
    session_start();
    
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();
?>