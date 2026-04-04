<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user = getCurrentUser();
$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? 0;

$success = false;

if ($action == 'remove') {
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user['id']);
    $success = $stmt->execute();
}

echo json_encode(['success' => $success]);
?>
