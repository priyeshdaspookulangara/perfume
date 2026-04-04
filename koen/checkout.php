<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

$page_title = 'Checkout';
include 'partials/header.php';

$cart = getCart();
if (empty($cart)) {
    header("Location: cart.php");
    exit();
}

$user = getCurrentUser();
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
?>

<section class="container px-4 py-5 mt-5">
  <div class="row g-5">
    <!-- Checkout Form -->
    <div class="col-lg-7 reveal">
      <h2 class="font-display display-5 mb-5 italic">Complete Your <em>Order</em></h2>

      <!-- Progress Bar -->
      <div class="d-flex align-items-center justify-content-between mb-5 px-lg-5">
        <div class="step-dot active" data-step="1"><span>1</span><small>Address</small></div>
        <div class="step-line"></div>
        <div class="step-dot" data-step="2"><span>2</span><small>Payment</small></div>
        <div class="step-line"></div>
        <div class="step-dot" data-step="3"><span>3</span><small>Review</small></div>
      </div>

      <form action="api/place-order.php" method="POST" id="checkoutForm">
        <!-- Step 1: Address -->
        <div id="step1" class="checkout-step">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="form-floating-gold">
                <input type="text" class="koen-input" id="fname" name="fname" placeholder=" " value="<?php echo $user['name'] ?? ''; ?>" required>
                <label>Full Name</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating-gold">
                <input type="email" class="koen-input" id="email" name="email" placeholder=" " value="<?php echo $user['email'] ?? ''; ?>" required>
                <label>Email Address</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating-gold">
                <input type="tel" class="koen-input" id="phone" name="phone" placeholder=" " required>
                <label>Phone Number</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating-gold">
                <input type="text" class="koen-input" id="pincode" name="pincode" placeholder=" " required>
                <label>Pincode</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-floating-gold">
                <input type="text" class="koen-input" id="address1" name="address1" placeholder=" " required>
                <label>Address Line 1</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating-gold">
                <input type="text" class="koen-input" id="city" name="city" placeholder=" " required>
                <label>City</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating-gold">
                <input type="text" class="koen-input" id="state" name="state" placeholder=" " required>
                <label>State</label>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-gold mt-5 px-5 py-3" id="toStep2">Continue to Payment →</button>
        </div>

        <!-- Step 2: Payment -->
        <div id="step2" class="checkout-step" style="display: none;">
          <h5 class="font-display fs-4 mb-4">Payment Method</h5>
          <div class="payment-options d-flex flex-column gap-3 mb-5">
            <div class="payment-card border border-gold p-4" style="cursor: pointer;">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="payUPI" value="UPI" checked>
                <label class="form-check-label font-ui small ls-wide" for="payUPI">UPI (Google Pay, PhonePe, Paytm)</label>
              </div>
            </div>
            <div class="payment-card border border-gold p-4" style="cursor: pointer;">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="payCard" value="Card">
                <label class="form-check-label font-ui small ls-wide" for="payCard">Credit / Debit Card</label>
              </div>
            </div>
            <div class="payment-card border border-gold p-4" style="cursor: pointer;">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="payCOD" value="COD">
                <label class="form-check-label font-ui small ls-wide" for="payCOD">Cash on Delivery (COD)</label>
              </div>
            </div>
          </div>
          <div class="d-flex gap-3">
            <button type="button" class="btn btn-outline-gold px-4 py-3 back-btn" data-back="1">← Back</button>
            <button type="button" class="btn btn-gold px-5 py-3 flex-grow-1" id="toStep3">Review Order →</button>
          </div>
        </div>

        <!-- Step 3: Review -->
        <div id="step3" class="checkout-step" style="display: none;">
          <div class="koen-card p-4 mb-5 border-gold border">
            <h5 class="font-display fs-4 mb-4">Final Review</h5>
            <div class="row g-4 font-ui small ls-wide text-muted-cream">
              <div class="col-md-6">
                <h6 class="text-gold small mb-2">SHIPPING ADDRESS</h6>
                <div id="reviewAddress"></div>
              </div>
              <div class="col-md-6">
                <h6 class="text-gold small mb-2">PAYMENT METHOD</h6>
                <div id="reviewPayment"></div>
              </div>
            </div>
          </div>
          <div class="d-flex gap-3">
            <button type="button" class="btn btn-outline-gold px-4 py-3 back-btn" data-back="2">← Back</button>
            <button type="submit" class="btn btn-gold px-5 py-3 flex-grow-1">Place Order <?php echo formatPrice($final_total); ?> Now</button>
          </div>
        </div>
      </form>
    </div>

    <!-- Summary Sidebar -->
    <div class="col-lg-5 reveal">
      <div class="koen-card p-4 sticky-top" style="top: 120px;">
        <h5 class="font-display mb-4 fs-4">Order Summary</h5>
        <div class="checkout-items d-flex flex-column gap-3 mb-4">
          <?php foreach($cart as $item): ?>
          <div class="d-flex align-items-center gap-3">
            <img src="<?php echo $item['image']; ?>" style="width: 50px; height: 60px; object-fit: cover;">
            <div class="flex-grow-1 overflow-hidden">
              <div class="font-display fs-6 text-truncate"><?php echo $item['name']; ?></div>
              <small class="text-muted-cream x-small font-ui ls-wide"><?php echo $item['size']; ?> × <?php echo $item['qty']; ?></small>
            </div>
            <div class="text-gold font-display fs-6"><?php echo formatPrice($item['price'] * $item['qty']); ?></div>
          </div>
          <?php endforeach; ?>
        </div>

        <hr style="border-color:var(--border)!important">

        <div class="summary-totals font-ui small ls-wide d-flex flex-column gap-2 mb-4">
          <div class="d-flex justify-content-between"><span>Subtotal</span><span><?php echo formatPrice($subtotal); ?></span></div>
          <?php if($discount > 0): ?>
          <div class="d-flex justify-content-between text-gold"><span>Discount</span><span>−<?php echo formatPrice($discount); ?></span></div>
          <?php endif; ?>
          <div class="d-flex justify-content-between"><span>Shipping</span><span><?php echo $shipping == 0 ? 'FREE' : formatPrice($shipping); ?></span></div>
          <div class="d-flex justify-content-between mt-3 font-display fs-4 text-gold">
            <span>Total</span>
            <span><?php echo formatPrice($final_total); ?></span>
          </div>
        </div>

        <div class="p-3 bg-dark border-start border-gold border-3 mb-2">
          <p class="mb-0 x-small font-ui ls-wide opacity-75">Estimated delivery by: <span class="text-cream"><?php echo date('d M, Y', strtotime('+5 days')); ?></span></p>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  function goToStep(s) {
    $('.checkout-step').hide();
    $(`#step${s}`).fadeIn();
    $('.step-dot').removeClass('active');
    $(`.step-dot[data-step="${s}"]`).addClass('active');
    window.scrollTo(0, 0);
  }

  $('#toStep2').click(function() {
    if($('#checkoutForm')[0].checkValidity()) goToStep(2);
    else $('#checkoutForm')[0].reportValidity();
  });

  $('#toStep3').click(function() {
    // Fill review data
    const addr = `${$('#fname').val()}<br>${$('#address1').val()}, ${$('#city').val()}<br>${$('#state').val()} - ${$('#pincode').val()}<br>T: ${$('#phone').val()}`;
    const pay = $('input[name="payment_method"]:checked').val();
    $('#reviewAddress').html(addr);
    $('#reviewPayment').text(pay);
    goToStep(3);
  });

  $('.back-btn').click(function() {
    goToStep($(this).data('back'));
  });
});
</script>

<?php include 'partials/footer.php'; ?>
