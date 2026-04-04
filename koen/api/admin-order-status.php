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
$status = $_POST['status'] ?? '';

$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
?>
