<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'koen_db';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Global settings
define('BASE_URL', '/koen/');
define('SITE_NAME', 'KOEN');
?>
