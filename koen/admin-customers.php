<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$customers = $conn->query("SELECT u.*, (SELECT COUNT(*) FROM orders WHERE user_id = u.id) as order_count, (SELECT SUM(final_total) FROM orders WHERE user_id = u.id) as total_spent FROM users u WHERE is_admin = 0 ORDER BY created_at DESC");

$page_title = 'Admin Customers';
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic">Manage <em>Customers</em></h2>
    </div>

    <div class="table-responsive">
      <table class="table table-dark table-borderless bg-transparent align-middle">
        <thead>
          <tr class="font-ui small text-gold ls-wide border-bottom border-gold border-opacity-10">
            <th class="py-3">CUSTOMER</th>
            <th class="py-3">EMAIL</th>
            <th class="py-3">ORDERS</th>
            <th class="py-3">TOTAL SPENT</th>
            <th class="py-3 text-end">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <?php while($u = $customers->fetch_assoc()): ?>
          <tr class="font-ui small ls-wide border-bottom border-gold border-opacity-10 align-middle">
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle" style="width: 35px; height: 35px; background: var(--gold); color: var(--ink); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Tenor Sans'; font-size: 10px;"><?php echo strtoupper(substr($u['name'], 0, 1)); ?></div>
                <div class="font-display fs-6"><?php echo e($u['name']); ?></div>
              </div>
            </td>
            <td class="py-3 text-muted"><?php echo e($u['email']); ?></td>
            <td class="py-3"><?php echo $u['order_count']; ?></td>
            <td class="py-3"><?php echo formatPrice($u['total_spent'] ?? 0); ?></td>
            <td class="py-3 text-end">
              <a href="admin-customer-detail.php?id=<?php echo $u['id']; ?>" class="btn btn-outline-gold btn-sm py-1">Details</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php include 'partials/footer.php'; ?>
