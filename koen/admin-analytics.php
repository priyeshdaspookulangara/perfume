<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$page_title = 'Admin Analytics';
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic">Store <em>Analytics</em></h2>
      <div class="d-flex gap-2">
          <input type="date" class="form-control bg-dark border-gold border-opacity-25 text-cream py-2 font-ui small" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>">
          <input type="date" class="form-control bg-dark border-gold border-opacity-25 text-cream py-2 font-ui small" value="<?php echo date('Y-m-d'); ?>">
      </div>
    </div>

    <div class="row g-5 mb-5">
      <div class="col-lg-12">
        <div class="koen-card p-5 border-gold border">
          <h4 class="font-display fs-3 mb-4">Daily Revenue (Last 30 Days)</h4>
          <canvas id="revenueChartFull" height="350"></canvas>
        </div>
      </div>
    </div>

    <div class="row g-5">
      <div class="col-lg-6">
        <div class="koen-card p-5 border-gold border h-100">
          <h4 class="font-display fs-3 mb-4">Top Selling Products</h4>
          <canvas id="topProductsChart" height="300"></canvas>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="koen-card p-5 border-gold border h-100">
          <h4 class="font-display fs-3 mb-4">Sales by Category</h4>
          <canvas id="categoryChart" height="300"></canvas>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
$(document).ready(function() {
  const ctxRevenueFull = document.getElementById('revenueChartFull').getContext('2d');
  new Chart(ctxRevenueFull, {
    type: 'line',
    data: {
      labels: Array.from({length: 30}, (_, i) => `Day ${i+1}`),
      datasets: [{
        data: Array.from({length: 30}, () => Math.floor(Math.random() * 50000) + 10000),
        borderColor: '#c4a46b',
        backgroundColor: 'rgba(196,164,107,0.08)',
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { color: '#8a7d6e' }, grid: { display: false } },
        y: { ticks: { color: '#8a7d6e' }, grid: { color: 'rgba(196,164,107,0.08)' } }
      }
    }
  });

  const ctxTop = document.getElementById('topProductsChart').getContext('2d');
  new Chart(ctxTop, {
    type: 'bar',
    data: {
      labels: ['Royal Oud', 'Saffron Silk', 'Velvet Rose', 'Amber Woods', 'Mystic Musk'],
      datasets: [{
        label: 'Units Sold',
        data: [120, 95, 80, 75, 60],
        backgroundColor: '#c4a46b'
      }]
    },
    options: {
      indexAxis: 'y',
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { color: '#8a7d6e' }, grid: { color: 'rgba(196,164,107,0.08)' } },
        y: { ticks: { color: '#f4efe6' }, grid: { display: false } }
      }
    }
  });

  const ctxCat = document.getElementById('categoryChart').getContext('2d');
  new Chart(ctxCat, {
    type: 'pie',
    data: {
      labels: ['Homme', 'Femme', 'Gifts', 'Atelier'],
      datasets: [{
        data: [40, 35, 15, 10],
        backgroundColor: ['#c4a46b', '#8a7d6e', '#7a4f2e', '#e8d5a3'],
        borderWidth: 0
      }]
    },
    options: {
      plugins: { legend: { position: 'right', labels: { color: '#f4efe6', font: { family: 'Tenor Sans' } } } }
    }
  });
});
</script>

<?php include 'partials/footer.php'; ?>
