<?php

    define('DATABASE_HOST', 'localhost');
    define('DATABASE_USER', 'root');
    define('DATABASE_PASS', '');
    define('DATABASE_NAME', 'biondi_616596');
    
    // Try and connect to database
    $connection = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}