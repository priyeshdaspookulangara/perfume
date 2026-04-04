<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$kpi_revenue = $conn->query("SELECT SUM(final_total) as total FROM orders WHERE status != 'Cancelled'")->fetch_assoc()['total'];
$kpi_orders = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$kpi_customers = $conn->query("SELECT COUNT(*) as count FROM users WHERE is_admin = 0")->fetch_assoc()['count'];
$kpi_products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];

$recent_orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");

$page_title = 'Admin Dashboard';
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <!-- Admin Sidebar -->
  <?php include 'partials/admin-sidebar.php'; ?>

  <!-- Main Admin Content -->
  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic">Admin <em>Dashboard</em></h2>
      <div class="text-muted small font-ui ls-wide"><?php echo date('l, d F Y'); ?></div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-4 mb-5">
      <div class="col-md-3">
        <div class="koen-card p-4 border-gold border">
          <span class="font-ui small ls-wide text-gold d-block mb-2">TOTAL REVENUE</span>
          <span class="font-display fs-2"><?php echo formatPrice($kpi_revenue ?? 0); ?></span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="koen-card p-4 border-gold border">
          <span class="font-ui small ls-wide text-gold d-block mb-2">ORDERS</span>
          <span class="font-display fs-2"><?php echo $kpi_orders; ?></span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="koen-card p-4 border-gold border">
          <span class="font-ui small ls-wide text-gold d-block mb-2">CUSTOMERS</span>
          <span class="font-display fs-2"><?php echo $kpi_customers; ?></span>
        </div>
      </div>
      <div class="col-md-3">
        <div class="koen-card p-4 border-gold border">
          <span class="font-ui small ls-wide text-gold d-block mb-2">PRODUCTS</span>
          <span class="font-display fs-2"><?php echo $kpi_products; ?></span>
        </div>
      </div>
    </div>

    <div class="row g-5 mb-5">
      <div class="col-lg-8">
        <div class="koen-card p-5 border-gold border h-100">
          <h4 class="font-display fs-3 mb-4">Revenue Overview</h4>
          <canvas id="revenueChart" height="250"></canvas>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="koen-card p-5 border-gold border h-100">
          <h4 class="font-display fs-3 mb-4">Orders by Status</h4>
          <canvas id="statusChart" height="250"></canvas>
        </div>
      </div>
    </div>

    <div class="recent-orders mt-5">
      <div class="d-flex justify-content-between align-items-end mb-4">
        <h4 class="font-display fs-3">Recent Orders</h4>
        <a href="admin-orders.php" class="text-gold font-ui small ls-wide text-decoration-none">View All</a>
      </div>
      <div class="table-responsive">
        <table class="table table-dark table-borderless bg-transparent">
          <thead>
            <tr class="font-ui small text-gold ls-wide border-bottom border-gold border-opacity-10">
              <th class="py-3">ORDER ID</th>
              <th class="py-3">CUSTOMER</th>
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
              <td class="py-3"><?php echo $o['full_name']; ?></td>
              <td class="py-3 text-muted"><?php echo date('d M, Y', strtotime($o['created_at'])); ?></td>
              <td class="py-3"><?php echo formatPrice($o['final_total']); ?></td>
              <td class="py-3"><span class="badge status-<?php echo strtolower($o['status']); ?>"><?php echo $o['status']; ?></span></td>
              <td class="py-3 text-end"><a href="admin-order-detail.php?id=<?php echo $o['id']; ?>" class="btn btn-outline-gold btn-sm py-1">Details</a></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>

<style>
.badge.status-placed { background: rgba(138,125,110,0.2); color: var(--gold); }
.badge.status-shipped { background: rgba(52,152,219,0.2); color: #3498db; }
.badge.status-delivered { background: rgba(46,204,113,0.2); color: #2ecc71; }
.badge.status-cancelled { background: rgba(231,76,60,0.2); color: #e74c3c; }
</style>

<script>
$(document).ready(function() {
  const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
  new Chart(ctxRevenue, {
    type: 'line',
    data: {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [{
        data: [12500, 19000, 15000, 24000, 18000, 32000, 28000],
        borderColor: '#c4a46b',
        backgroundColor: 'rgba(196,164,107,0.08)',
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#c4a46b'
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { color: '#8a7d6e' }, grid: { display: false } },
        y: { ticks: { color: '#8a7d6e' }, grid: { color: 'rgba(196,164,107,0.08)' } }
      }
    }
  });

  const ctxStatus = document.getElementById('statusChart').getContext('2d');
  new Chart(ctxStatus, {
    type: 'doughnut',
    data: {
      labels: ['Placed', 'Shipped', 'Delivered', 'Cancelled'],
      datasets: [{
        data: [45, 25, 100, 10],
        backgroundColor: ['#c4a46b', '#3498db', '#2ecc71', '#e74c3c'],
        borderWidth: 0
      }]
    },
    options: {
      plugins: { legend: { position: 'bottom', labels: { color: '#f4efe6', padding: 20, font: { family: 'Tenor Sans', size: 10 } } } },
      cutout: '70%'
    }
  });
});
</script>

<?php include 'partials/footer.php'; ?>
