<?php
function formatPrice($price) {
    return '₹' . number_format($price, 0);
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function getCart() {
    return $_SESSION['cart'] ?? [];
}

function updateCart($cart) {
    $_SESSION['cart'] = $cart;
}

function addToCart($productId, $sizeId, $qty = 1) {
    global $conn;
    $cart = getCart();

    // Validate product and size
    $stmt = $conn->prepare("SELECT p.name, p.image, ps.ml, ps.price FROM products p JOIN product_sizes ps ON p.id = ps.product_id WHERE p.id = ? AND ps.id = ?");
    $stmt->bind_param("ii", $productId, $sizeId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows == 0) return false;

    $item_info = $res->fetch_assoc();
    $key = $productId . '-' . $sizeId;

    if (isset($cart[$key])) {
        $cart[$key]['qty'] += $qty;
    } else {
        $cart[$key] = [
            'id' => $productId,
            'size_id' => $sizeId,
            'name' => $item_info['name'],
            'image' => $item_info['image'],
            'size' => $item_info['ml'] . 'ml',
            'price' => $item_info['price'],
            'qty' => $qty
        ];
    }
    updateCart($cart);
    return true;
}

function getCartTotal() {
    $total = 0;
    foreach (getCart() as $item) {
        $total += $item['price'] * $item['qty'];
    }
    return $total;
}

function getCartCount() {
    $count = 0;
    foreach (getCart() as $item) {
        $count += $item['qty'];
    }
    return $count;
}
?>
