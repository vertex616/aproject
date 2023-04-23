<?php

// Set database credentials
$db_host = 'localhost';
$db_name = 'u_220000253_db';
$username = 'u-220000253';
$password = 'nlWafaMMESZatXK';

try {
    // Create a new PDO instance and pass the database credentials
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password);
    // Set PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Display error message and exit
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}


?>