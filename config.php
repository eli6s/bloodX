<?php
$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'blood_bank';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";

try {
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $conn = new PDO($dsn, $username, $password, $options);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
