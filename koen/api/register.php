<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$pass = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $pass);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['user_name'] = $name;
    $_SESSION['is_admin'] = 0;
    header("Location: ../account.php");
} else {
    header("Location: ../auth.php?register_error=1");
}
?>
