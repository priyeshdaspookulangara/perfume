<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$user_id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();

if (!$customer) {
    header("Location: admin-customers.php");
    exit();
}

$page_title = 'Customer Detail: ' . $customer['name'];
include 'partials/header.php';

// Fetch customer orders
$orders_res = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<div class="d-flex">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-4" style="margin-left: 220px;">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h2 class="font-display mb-0">Customer <em>Detail</em></h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb font-ui small ls-wide mb-0">
            <li class="breadcrumb-item"><a href="admin-dashboard.php" class="text-muted">Admin</a></li>
            <li class="breadcrumb-item"><a href="admin-customers.php" class="text-muted">Customers</a></li>
            <li class="breadcrumb-item text-gold active"><?php echo e($customer['name']); ?></li>
          </ol>
        </nav>
      </div>
      <a href="admin-customers.php" class="btn btn-outline-gold btn-sm"><i class="bi bi-arrow-left me-2"></i>Back to List</a>
    </div>

    <div class="row g-4">
      <div class="col-lg-4">
        <div class="koen-card p-4">
          <div class="text-center mb-4">
            <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 24px;">
              <?php
                $names = explode(' ', $customer['name']);
                echo strtoupper(substr($names[0], 0, 1) . (isset($names[1]) ? substr($names[1], 0, 1) : ''));
              ?>
            </div>
            <h4 class="font-display mb-1"><?php echo e($customer['name']); ?></h4>
            <span class="badge <?php echo $customer['is_admin'] ? 'bg-gold text-dark' : 'bg-secondary'; ?> font-ui small ls-wide">
              <?php echo $customer['is_admin'] ? 'ADMIN' : 'CUSTOMER'; ?>
            </span>
          </div>

          <hr style="border-color: var(--border) !important;">

          <div class="mb-4">
            <label class="font-ui text-gold small ls-wide d-block mb-1">Email</label>
            <p class="text-cream mb-0"><?php echo e($customer['email']); ?></p>
          </div>
          <div class="mb-4">
            <label class="font-ui text-gold small ls-wide d-block mb-1">Phone</label>
            <p class="text-cream mb-0"><?php echo e($customer['phone'] ?: 'N/A'); ?></p>
          </div>
          <div class="mb-0">
            <label class="font-ui text-gold small ls-wide d-block mb-1">Registered On</label>
            <p class="text-cream mb-0"><?php echo date('M d, Y', strtotime($customer['created_at'])); ?></p>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="koen-card p-4">
          <h5 class="font-display mb-4">Order <em>History</em></h5>
          <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle">
              <thead>
                <tr class="font-ui text-gold small ls-wide" style="border-bottom: 1px solid var(--border)">
                  <th>Order #</th>
                  <th>Date</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if($orders_res->num_rows > 0): ?>
                  <?php while($order = $orders_res->fetch_assoc()): ?>
                    <tr>
                      <td class="font-ui"><?php echo e($order['order_number']); ?></td>
                      <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                      <td class="text-gold font-display"><?php echo formatPrice($order['final_total']); ?></td>
                      <td>
                        <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                          <?php echo e($order['status']); ?>
                        </span>
                      </td>
                      <td>
                        <a href="admin-order-detail.php?id=<?php echo $order['id']; ?>" class="btn btn-link text-gold p-0"><i class="bi bi-eye"></i></a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No orders found for this customer.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<?php include 'partials/footer.php'; ?>
