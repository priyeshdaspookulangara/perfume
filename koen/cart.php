<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

$page_title = 'Cart';
include 'partials/header.php';

$cart = getCart();
$subtotal = getCartTotal();
$shipping = $subtotal > 799 ? 0 : 79;
$total = $subtotal + $shipping;

$discount = 0;
if (isset($_SESSION['coupon'])) {
    $coupon = $_SESSION['coupon'];
    if ($subtotal >= $coupon['min_order']) {
        if ($coupon['type'] == 'percent') $discount = ($subtotal * $coupon['value'] / 100);
        else $discount = $coupon['value'];
    }
}
$final_total = $subtotal - $discount + $shipping;
?>

<section class="container px-4 py-5 mt-5 min-vh-100">
  <div class="row g-5">
    <!-- Cart Items -->
    <div class="col-lg-8">
      <h2 class="font-display display-5 mb-5 reveal">Your <em>Bag</em></h2>

      <div id="cartItemsList" class="reveal">
        <?php if(empty($cart)): ?>
          <div class="text-center py-5">
            <p class="font-display fs-2 fst-italic text-muted">Your cart is empty</p>
            <a href="shop.php" class="btn btn-gold mt-4 px-5">Continue Shopping</a>
          </div>
        <?php else: ?>
          <?php foreach($cart as $key => $item): ?>
            <div class="cart-row d-flex align-items-center gap-4 py-4 border-top" style="border-color:var(--border)!important" data-key="<?php echo $key; ?>">
              <img src="<?php echo $item['image']; ?>" style="width:100px;height:130px;object-fit:cover;filter:brightness(.85)">
              <div class="flex-grow-1">
                <div class="font-display fs-4"><?php echo $item['name']; ?></div>
                <small class="text-muted-cream font-ui ls-wide"><?php echo $item['size']; ?></small>
                <div class="d-flex align-items-center gap-2 mt-3">
                  <button class="btn btn-outline-gold btn-sm qty-minus px-2 py-0" data-key="<?php echo $key; ?>">−</button>
                  <span class="qty-num px-3 font-ui"><?php echo $item['qty']; ?></span>
                  <button class="btn btn-outline-gold btn-sm qty-plus px-2 py-0" data-key="<?php echo $key; ?>">+</button>
                </div>
              </div>
              <div class="text-end">
                <div class="text-gold font-display fs-4 mb-2"><?php echo formatPrice($item['price'] * $item['qty']); ?></div>
                <button class="btn btn-link text-muted-cream remove-item p-0" data-key="<?php echo $key; ?>"><i class="bi bi-trash fs-5"></i></button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <!-- Summary -->
    <div class="col-lg-4">
      <div class="koen-card p-4 reveal" style="position: sticky; top: 120px;">
        <h5 class="font-display mb-4 fs-4">Order Summary</h5>
        <div class="d-flex justify-content-between mb-3"><span class="small font-ui ls-wide">Subtotal</span><span id="summarySubtotal"><?php echo formatPrice($subtotal); ?></span></div>

        <?php if($discount > 0): ?>
        <div class="d-flex justify-content-between mb-3 text-gold">
          <span class="small font-ui ls-wide">Discount (<?php echo $_SESSION['coupon']['code']; ?>)</span>
          <span>−<?php echo formatPrice($discount); ?></span>
        </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between mb-3"><span class="small font-ui ls-wide">Shipping</span><span><?php echo $shipping == 0 ? 'FREE' : formatPrice($shipping); ?></span></div>
        <hr style="border-color:var(--border)!important">
        <div class="d-flex justify-content-between mb-4 mt-2">
          <span class="font-display fs-4">Total</span>
          <span class="font-display fs-3 text-gold" id="summaryTotal"><?php echo formatPrice($final_total); ?></span>
        </div>

        <form action="api/apply-coupon.php" method="POST" id="couponForm" class="mb-4">
          <div class="input-group">
            <input type="text" name="code" class="form-control bg-transparent border-gold text-cream rounded-0 px-3 py-2 font-ui small ls-wide" placeholder="Coupon Code">
            <button class="btn btn-outline-gold px-4 rounded-0" type="submit">Apply</button>
          </div>
          <?php if(isset($_GET['coupon_error'])): ?>
            <small class="text-danger mt-2 d-block font-ui small"><?php echo htmlspecialchars($_GET['coupon_error']); ?></small>
          <?php endif; ?>
        </form>

        <a href="checkout.php" class="btn btn-gold w-100 py-3 <?php echo empty($cart) ? 'disabled' : ''; ?>">Proceed to Checkout</a>
        <div class="d-flex justify-content-center align-items-center gap-2 mt-4 opacity-50">
          <i class="bi bi-lock-fill text-gold small"></i>
          <small class="text-muted-cream font-ui ls-wide x-small">100% Secure Checkout</small>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
