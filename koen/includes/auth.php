<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

function requireAuth() {
    if (!isLoggedIn()) {
        header("Location: auth.php");
        exit();
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header("Location: admin-login.php");
        exit();
    }
}

function getCurrentUser() {
    global $conn;
    if (!isLoggedIn()) return null;
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
?>
