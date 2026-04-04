<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

$email = $_POST['email'] ?? '';
$pass = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($pass, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['is_admin'] = $user['is_admin'];

    if ($user['is_admin']) header("Location: ../admin-dashboard.php");
    else header("Location: ../account.php");
} else {
    header("Location: ../auth.php?login_error=1");
}
?>
