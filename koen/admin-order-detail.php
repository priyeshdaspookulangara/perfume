<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$order_id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header("Location: admin-orders.php");
    exit();
}

$stmt_items = $conn->prepare("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items = $stmt_items->get_result();

$page_title = 'Order Detail #' . $order['order_number'];
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic">Order Detail <em>#<?php echo e($order['order_number']); ?></em></h2>
      <a href="admin-orders.php" class="text-gold font-ui small ls-wide text-decoration-none">← Back to List</a>
    </div>

    <div class="row g-5">
      <div class="col-lg-8">
        <div class="koen-card p-5 border-gold border mb-5">
          <h4 class="font-display fs-3 mb-4">Items Ordered</h4>
          <div class="table-responsive">
            <table class="table table-dark table-borderless bg-transparent align-middle">
              <tbody>
                <?php while($item = $items->fetch_assoc()): ?>
                <tr class="border-bottom border-gold border-opacity-10">
                  <td class="py-4" style="width: 80px;">
                    <img src="<?php echo e($item['image']); ?>" style="width: 60px; height: 80px; object-fit: cover;">
                  </td>
                  <td class="py-4">
                    <div class="font-display fs-5"><?php echo e($item['name']); ?></div>
                    <small class="text-muted-cream font-ui x-small"><?php echo e($item['size_ml']); ?>ml × <?php echo e($item['quantity']); ?></small>
                  </td>
                  <td class="py-4 text-end">
                    <div class="text-gold font-display fs-5"><?php echo formatPrice($item['price'] * $item['quantity']); ?></div>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="koen-card p-4 border-gold border h-100">
                    <h6 class="font-ui text-gold small ls-wide mb-3">SHIPPING ADDRESS</h6>
                    <p class="text-muted-cream font-ui small ls-wide mb-0">
                        <?php echo e($order['full_name']); ?><br>
                        <?php echo e($order['address1']); ?><br>
                        <?php if($order['address2']) echo e($order['address2']) . '<br>'; ?>
                        <?php echo e($order['city']); ?>, <?php echo e($order['state']); ?> - <?php echo e($order['pincode']); ?><br>
                        T: <?php echo e($order['phone']); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="koen-card p-4 border-gold border h-100">
                    <h6 class="font-ui text-gold small ls-wide mb-3">PAYMENT INFO</h6>
                    <p class="text-muted-cream font-ui small ls-wide mb-0">
                        Method: <?php echo e($order['payment_method']); ?><br>
                        Status: <?php echo e($order['status']); ?>
                    </p>
                </div>
            </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="koen-card p-4 border-gold border sticky-top" style="top: 120px;">
          <h4 class="font-display fs-3 mb-4">Summary</h4>
          <div class="d-flex flex-column gap-3 font-ui small ls-wide text-muted-cream">
            <div class="d-flex justify-content-between"><span>Subtotal</span><span><?php echo formatPrice($order['total_amount']); ?></span></div>
            <div class="d-flex justify-content-between text-gold"><span>Discount</span><span>−<?php echo formatPrice($order['discount_amount']); ?></span></div>
            <div class="d-flex justify-content-between"><span>Shipping</span><span><?php echo formatPrice($order['shipping_fee']); ?></span></div>
            <hr class="opacity-10">
            <div class="d-flex justify-content-between font-display fs-3 text-gold"><span>Total</span><span><?php echo formatPrice($order['final_total']); ?></span></div>
          </div>

          <div class="mt-5">
              <label class="font-ui x-small ls-wider text-gold mb-2 d-block">UPDATE ORDER STATUS</label>
              <select class="form-select bg-dark text-cream border-gold border-opacity-25 py-3 font-ui small update-status" data-id="<?php echo $order['id']; ?>">
                <option value="Placed" <?php echo $order['status'] == 'Placed' ? 'selected' : ''; ?>>Placed</option>
                <option value="Shipped" <?php echo $order['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                <option value="Delivered" <?php echo $order['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
              </select>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<?php include 'partials/footer.php'; ?>
