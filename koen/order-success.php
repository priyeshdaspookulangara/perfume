<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

if (!isset($_SESSION['last_order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_SESSION['last_order_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

$page_title = 'Order Confirmed';
include 'partials/header.php';
?>

<section class="container px-4 py-5 mt-5 min-vh-75 d-flex align-items-center justify-content-center">
  <div class="text-center reveal" style="max-width: 600px;">
    <div class="success-icon mb-5">
      <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="60" cy="60" r="58" stroke="var(--gold)" stroke-width="2" />
        <path d="M35 60L52 77L85 44" stroke="var(--gold)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="check-draw" />
      </svg>
    </div>

    <h1 class="font-display display-3 mb-4 italic">Order <em>Confirmed!</em></h1>
    <p class="text-muted-cream font-ui ls-wide mb-5">Thank you for choosing Koen. Your order has been placed successfully and we're preparing your scent discovery journey.</p>

    <div class="koen-card p-4 mb-5 border-gold border">
      <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom" style="border-color: var(--border) !important;">
        <span class="font-ui small ls-wide text-muted">ORDER NUMBER</span>
        <span class="font-ui small ls-wide text-gold"><?php echo $order['order_number']; ?></span>
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <span class="font-ui small ls-wide text-muted">ESTIMATED DELIVERY</span>
        <span class="font-ui small ls-wide text-cream"><?php echo date('d M, Y', strtotime($order['created_at'] . ' + 5 days')); ?></span>
      </div>
    </div>

    <div class="d-flex gap-3 justify-content-center">
      <a href="shop.php" class="btn btn-gold px-5 py-3">Continue Shopping</a>
      <a href="account-orders.php" class="btn btn-outline-gold px-5 py-3">Track Order</a>
    </div>
  </div>
</section>

<style>
.check-draw {
  stroke-dasharray: 100;
  stroke-dashoffset: 100;
  animation: checkmark 1.5s ease-in-out forwards 0.5s;
}
@keyframes checkmark {
  to { stroke-dashoffset: 0; }
}
</style>

<?php include 'partials/footer.php'; ?>
