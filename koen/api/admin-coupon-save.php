<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

header('Content-Type: application/json');

if (!isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

if (!validate_csrf($_POST['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'CSRF validation failed']);
    exit();
}

$id = intval($_POST['id'] ?? 0);
$code = $_POST['code'] ?? '';
$type = $_POST['type'] ?? 'percent';
$value = floatval($_POST['value'] ?? 0);
$min_order = floatval($_POST['min_order'] ?? 0);

if (empty($code)) {
    echo json_encode(['success' => false, 'message' => 'Coupon code is required']);
    exit();
}

if ($id > 0) {
    // Update
    $stmt = $conn->prepare("UPDATE coupons SET code = ?, type = ?, value = ?, min_order = ? WHERE id = ?");
    $stmt->bind_param("ssddi", $code, $type, $value, $min_order, $id);
} else {
    // Insert
    $stmt = $conn->prepare("INSERT INTO coupons (code, type, value, min_order) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdd", $code, $type, $value, $min_order);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Coupon saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error saving coupon: ' . $conn->error]);
}
?>
