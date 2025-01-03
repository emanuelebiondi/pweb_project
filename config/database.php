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

mysqli_report(MYSQLI_REPORT_OFF); // Per non avere errori nelle api

// Try and connect to database
$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
if (mysqli_connect_errno()) {
  // If there is an error with the connection, display the error and stop the script.
  die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

//echo "Status: Connected successfully!";

// Rendi la connessione globale
global $conn;
$conn = $connection; // Assegna la connessione alla variabile globale $conn

?>