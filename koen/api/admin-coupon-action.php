<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$id = $_POST['id'] ?? 0;
$action = $_POST['action'] ?? 'remove';

if ($action == 'remove') {
    $stmt = $conn->prepare("DELETE FROM coupons WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
} else {
    $success = false;
}

echo json_encode(['success' => $success]);
?>
