<?php
$host = 'localhost';
$user = 'jeoczvkk_jeoczvkk';
$pass = 'pearl$Pearl$';
$db   = 'jeoczvkk_perfume';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Global settings
define('BASE_URL', 'https://empress2way.com/vansale/perfume/perfume-feature-koen-ecommerce-site-15197816524596718193/koen/');
define('SITE_NAME', 'KOEN');
?>
