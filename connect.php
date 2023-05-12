<?php
// Define database connection parameters
$host = 'localhost';
$dbname = 'mediatheque';
$user = 'root';
$pass = '';

// Create a PDO instance as database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Set PDO error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully to database.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
