<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

$code = $_POST['code'] ?? '';
$success = false;
$message = "";

$stmt = $conn->prepare("SELECT * FROM coupons WHERE code = ? AND active = 1");
$stmt->bind_param("s", $code);
$stmt->execute();
$coupon = $stmt->get_result()->fetch_assoc();

if ($coupon) {
    $_SESSION['coupon'] = $coupon;
    $success = true;
} else {
    $message = "Invalid coupon code";
}

header("Location: ../cart.php" . ($success ? "" : "?coupon_error=$message"));
?>
