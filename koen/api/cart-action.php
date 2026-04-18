<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';
$p_id = $_POST['product_id'] ?? 0;
$s_id = $_POST['size_id'] ?? 0;
$qty = $_POST['qty'] ?? 1;
$key = $_POST['key'] ?? '';

$success = false;
$message = "";

switch ($action) {
    case 'add':
        if (!$s_id) {
            // Find default size
            $stmt = $conn->prepare("SELECT id FROM product_sizes WHERE product_id = ? LIMIT 1");
            $stmt->bind_param("i", $p_id);
            $stmt->execute();
            $s_id = $stmt->get_result()->fetch_assoc()['id'] ?? 0;
        }
        $success = addToCart($p_id, $s_id, $qty);
        $message = "Added to bag";
        break;

    case 'update':
        $cart = getCart();
        if (isset($cart[$key])) {
            $cart[$key]['qty'] = max(1, $qty);
            updateCart($cart);
            $success = true;
        }
        break;

    case 'remove':
        $cart = getCart();
        if (isset($cart[$key])) {
            unset($cart[$key]);
            updateCart($cart);
            $success = true;
        }
        break;

    case 'stats':
        $success = true;
        break;
}

echo json_encode(['success' => $success, 'message' => $message, 'cartCount' => getCartCount(), 'cartTotal' => getCartTotal()]);
?>
