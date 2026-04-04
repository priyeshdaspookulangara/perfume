<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAuth();

$user = getCurrentUser();
$initials = strtoupper(substr($user['name'], 0, 1) . substr(explode(' ', $user['name'])[1] ?? '', 0, 1));

// Stats
$order_stats = $conn->query("SELECT COUNT(*) as count, SUM(final_total) as total FROM orders WHERE user_id = {$user['id']}")->fetch_assoc();
$wishlist_count = $conn->query("SELECT COUNT(*) as count FROM wishlist WHERE user_id = {$user['id']}")->fetch_assoc()['count'];

// Recent orders
$recent_orders = $conn->query("SELECT * FROM orders WHERE user_id = {$user['id']} ORDER BY created_at DESC LIMIT 3");

$page_title = 'My Account';
include 'partials/header.php';
?>

<section class="container px-4 py-5 mt-5 min-vh-100">
  <div class="row g-5">
    <!-- Sidebar -->
    <aside class="col-lg-3 reveal">
      <div class="koen-card p-4 position-sticky" style="top: 100px;">
        <div class="d-flex align-items-center gap-3 mb-4 pb-4 border-bottom border-gold border-opacity-10">
          <div class="avatar-circle" style="width: 50px; height: 50px; background: var(--gold); color: var(--ink); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Tenor Sans';"><?php echo $initials; ?></div>
          <div>
            <div class="font-display fs-5"><?php echo $user['name']; ?></div>
            <small class="text-muted-cream font-ui x-small"><?php echo $user['email']; ?></small>
          </div>
        </div>
        <nav class="d-flex flex-column gap-1">
          <a href="account.php" class="account-nav-link active">Dashboard</a>
          <a href="account-orders.php" class="account-nav-link">My Orders</a>
          <a href="account-wishlist.php" class="account-nav-link">Wishlist</a>
          <a href="account-profile.php" class="account-nav-link">Profile Settings</a>
          <hr class="my-3 opacity-10">
          <a href="api/logout.php" class="account-nav-link opacity-50">Logout</a>
        </nav>
      </div>
    </aside>

    <!-- Content -->
    <main class="col-lg-9 reveal">
      <h1 class="font-display display-5 mb-5 italic">Welcome back, <em><?php echo explode(' ', $user['name'])[0]; ?></em></h1>

      <div class="row g-4 mb-5">
        <div class="col-md-4">
          <div class="koen-card p-4 border-gold border">
            <span class="font-ui small ls-wide text-gold d-block mb-2">TOTAL ORDERS</span>
            <span class="font-display fs-2"><?php echo $order_stats['count']; ?></span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="koen-card p-4 border-gold border">
            <span class="font-ui small ls-wide text-gold d-block mb-2">TOTAL SPENT</span>
            <span class="font-display fs-2"><?php echo formatPrice($order_stats['total'] ?? 0); ?></span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="koen-card p-4 border-gold border">
            <span class="font-ui small ls-wide text-gold d-block mb-2">WISHLIST</span>
            <span class="font-display fs-2"><?php echo $wishlist_count; ?> Items</span>
          </div>
        </div>
      </div>

      <div class="recent-orders reveal mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
          <h4 class="font-display fs-3">Recent Orders</h4>
          <a href="account-orders.php" class="text-gold font-ui small ls-wide text-decoration-none">View All</a>
        </div>
        <div class="table-responsive">
          <table class="table table-dark table-borderless bg-transparent">
            <thead>
              <tr class="font-ui small text-gold ls-wide border-bottom border-gold border-opacity-10">
                <th class="py-3">ORDER ID</th>
                <th class="py-3">DATE</th>
                <th class="py-3">TOTAL</th>
                <th class="py-3">STATUS</th>
                <th class="py-3 text-end">ACTION</th>
              </tr>
            </thead>
            <tbody>
              <?php while($o = $recent_orders->fetch_assoc()): ?>
              <tr class="font-ui small ls-wide border-bottom border-gold border-opacity-10 align-middle">
                <td class="py-3">#<?php echo $o['order_number']; ?></td>
                <td class="py-3 text-muted"><?php echo date('d M, Y', strtotime($o['created_at'])); ?></td>
                <td class="py-3"><?php echo formatPrice($o['final_total']); ?></td>
                <td class="py-3"><span class="badge status-<?php echo strtolower($o['status']); ?>"><?php echo $o['status']; ?></span></td>
                <td class="py-3 text-end"><a href="account-order-detail.php?id=<?php echo $o['id']; ?>" class="btn btn-outline-gold btn-sm py-1">View</a></td>
              </tr>
              <?php endwhile; ?>
              <?php if($recent_orders->num_rows == 0): ?>
              <tr><td colspan="5" class="py-5 text-center text-muted font-display fs-4">No orders placed yet.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</section>

<style>
.account-nav-link {
  padding: 12px 0;
  color: var(--muted-cream);
  text-decoration: none;
  font-family: 'Tenor Sans';
  font-size: 11px;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  border-bottom: 1px solid transparent;
  transition: all 0.3s;
}
.account-nav-link.active, .account-nav-link:hover {
  color: var(--gold);
  border-bottom-color: var(--gold);
}
.badge.status-placed { background: rgba(138,125,110,0.2); color: var(--gold); }
.badge.status-shipped { background: rgba(52,152,219,0.2); color: #3498db; }
.badge.status-delivered { background: rgba(46,204,113,0.2); color: #2ecc71; }
.badge.status-cancelled { background: rgba(231,76,60,0.2); color: #e74c3c; }
</style>

<?php include 'partials/footer.php'; ?>
