


<?php
    
    if (!defined('DBHOST')) {
        define('DBHOST', 'localhost');
    }

    if (!defined('DBUSER')) {
        define('DBUSER', 'root');
    }

    if (!defined('DBPASS')) {
        define('DBPASS', '');
    }

    if (!defined('DBNAME')) {
        define('DBNAME', 'biondi_616596');
    }

    
    // Try and connect to database
    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if ( mysqli_connect_errno() ) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

?>