<?php
include_once '../includes/db.php';
include_once '../includes/auth.php';
include_once '../includes/functions.php';

if (empty(getCart())) {
    header("Location: ../cart.php");
    exit();
}

$user = getCurrentUser();
$user_id = $user['id'] ?? null;
$order_number = 'KN' . time();

$subtotal = getCartTotal();
$shipping = $subtotal > 799 ? 0 : 79;
$discount = 0;
if (isset($_SESSION['coupon'])) {
    $coupon = $_SESSION['coupon'];
    if ($subtotal >= $coupon['min_order']) {
        if ($coupon['type'] == 'percent') $discount = ($subtotal * $coupon['value'] / 100);
        else $discount = $coupon['value'];
    }
}
$final_total = $subtotal - $discount + $shipping;

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("INSERT INTO orders (order_number, user_id, full_name, email, phone, address1, address2, city, state, pincode, total_amount, discount_amount, shipping_fee, final_total, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssssssdddds",
        $order_number, $user_id, $_POST['fname'], $_POST['email'], $_POST['phone'],
        $_POST['address1'], $_POST['address2'], $_POST['city'], $_POST['state'],
        $_POST['pincode'], $subtotal, $discount, $shipping, $final_total, $_POST['payment_method']
    );
    $stmt->execute();
    $order_id = $conn->insert_id;

    foreach (getCart() as $item) {
        $stmt_i = $conn->prepare("INSERT INTO order_items (order_id, product_id, size_ml, price, quantity) VALUES (?, ?, ?, ?, ?)");
        $size_ml = (int)$item['size'];
        $stmt_i->bind_param("iiidi", $order_id, $item['id'], $size_ml, $item['price'], $item['qty']);
        $stmt_i->execute();
    }

    $conn->commit();

    // Success - Clear cart and coupon
    updateCart([]);
    unset($_SESSION['coupon']);
    $_SESSION['last_order_id'] = $order_id;

    header("Location: ../order-success.php");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    die("Error placing order: " . $e->getMessage());
}
?>
