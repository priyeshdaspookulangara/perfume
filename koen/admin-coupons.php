<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$coupons = $conn->query("SELECT * FROM coupons ORDER BY created_at DESC");

$page_title = 'Admin Coupons';
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic">Manage <em>Coupons</em></h2>
      <button class="btn btn-gold px-4 py-2" data-bs-toggle="modal" data-bs-target="#addCouponModal"><i class="bi bi-plus-lg me-2"></i> CREATE COUPON</button>
    </div>

    <div class="table-responsive">
      <table class="table table-dark table-borderless bg-transparent align-middle">
        <thead>
          <tr class="font-ui small text-gold ls-wide border-bottom border-gold border-opacity-10">
            <th class="py-3">CODE</th>
            <th class="py-3">TYPE</th>
            <th class="py-3">VALUE</th>
            <th class="py-3">MIN ORDER</th>
            <th class="py-3 text-end">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <?php while($c = $coupons->fetch_assoc()): ?>
          <tr class="font-ui small ls-wide border-bottom border-gold border-opacity-10 align-middle">
            <td class="py-3">
              <span class="badge bg-gold text-dark font-ui px-3 py-2 fs-6"><?php echo e($c['code']); ?></span>
            </td>
            <td class="py-3 text-muted"><?php echo strtoupper($c['type']); ?></td>
            <td class="py-3"><?php echo $c['type'] == 'percent' ? $c['value'] . '%' : formatPrice($c['value']); ?></td>
            <td class="py-3"><?php echo formatPrice($c['min_order']); ?></td>
            <td class="py-3 text-end">
              <button class="btn btn-link text-danger p-0 delete-coupon" data-id="<?php echo $c['id']; ?>"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<!-- Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-ink border-gold border-opacity-25 rounded-0 p-4">
      <h3 class="font-display display-5 mb-5 italic text-center">New <em>Coupon</em></h3>
      <form action="api/admin-coupon-save.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <div class="form-floating-gold mb-4">
          <input type="text" name="code" class="koen-input" placeholder=" " required>
          <label>Coupon Code (e.g., WELCOME20)</label>
        </div>
        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="form-floating-gold">
              <select name="type" class="koen-input" style="appearance: none;" required>
                <option value="percent">Percentage (%)</option>
                <option value="fixed">Fixed Amount (₹)</option>
              </select>
              <label>Discount Type</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating-gold">
              <input type="number" name="value" class="koen-input" placeholder=" " required>
              <label>Discount Value</label>
            </div>
          </div>
        </div>
        <div class="form-floating-gold mb-5">
          <input type="number" name="min_order" class="koen-input" value="0" placeholder=" " required>
          <label>Minimum Order Amount (₹)</label>
        </div>
        <button type="submit" class="btn btn-gold w-100 py-3">CREATE COUPON</button>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('.delete-coupon').on('click', function() {
    if(confirm('Are you sure you want to delete this coupon?')) {
      const id = $(this).data('id');
      const row = $(this).closest('tr');
      $.post('api/admin-coupon-delete.php', { id: id }, function(res) {
        if(res.success) {
          row.fadeOut();
          showToast('Coupon deleted');
        } else {
          showToast(res.message, 'error');
        }
      });
    }
  });
});
</script>

<?php include 'partials/footer.php'; ?>
