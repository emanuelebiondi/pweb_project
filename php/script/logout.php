<?php
// Start the session
    if (!isset($_SESSION)) session_start();

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or homepage
    header("Location: ../../index.php");
    exit;

?>