<?php
if (!isset($conn)) {
    include_once __DIR__ . '/../includes/db.php';
    include_once __DIR__ . '/../includes/functions.php';
}

$cart = getCart();
if (empty($cart)) {
    echo '<div class="text-center py-5"><p class="font-display fs-4 fst-italic text-muted">Your cart is empty</p></div>';
} else {
    foreach ($cart as $key => $item) {
        ?>
        <div class="cart-row d-flex align-items-center gap-3 py-4 border-top" style="border-color:var(--border)!important" data-key="<?php echo $key; ?>">
          <img src="<?php echo $item['image']; ?>" style="width:70px;height:90px;object-fit:cover;filter:brightness(.85)">
          <div class="flex-grow-1">
            <div class="font-display fs-6"><?php echo $item['name']; ?></div>
            <small class="text-muted-cream"><?php echo $item['size']; ?></small>
            <div class="d-flex align-items-center gap-2 mt-2">
              <button class="btn btn-outline-gold btn-sm qty-minus px-2 py-0" data-key="<?php echo $key; ?>">−</button>
              <span class="qty-num px-2"><?php echo $item['qty']; ?></span>
              <button class="btn btn-outline-gold btn-sm qty-plus px-2 py-0" data-key="<?php echo $key; ?>">+</button>
            </div>
          </div>
          <div class="text-end">
            <div class="text-gold font-display fs-6"><?php echo formatPrice($item['price'] * $item['qty']); ?></div>
            <button class="btn btn-link text-muted-cream btn-sm remove-item mt-1 p-0" data-key="<?php echo $key; ?>"><i class="bi bi-trash"></i></button>
          </div>
        </div>
        <?php
    }
}
?>
