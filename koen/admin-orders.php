<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$orders = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");

$page_title = 'Admin Orders';
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic">Manage <em>Orders</em></h2>
    </div>

    <div class="table-responsive">
      <table class="table table-dark table-borderless bg-transparent align-middle">
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
          <?php while($o = $orders->fetch_assoc()): ?>
          <tr class="font-ui small ls-wide border-bottom border-gold border-opacity-10">
            <td class="py-3">#<?php echo e($o['order_number']); ?></td>
            <td class="py-3">
              <div class="font-display fs-6"><?php echo e($o['full_name']); ?></div>
              <small class="text-muted-cream font-ui x-small"><?php echo e($o['email']); ?></small>
            </td>
            <td class="py-3 text-muted"><?php echo date('d M, Y', strtotime($o['created_at'])); ?></td>
            <td class="py-3"><?php echo formatPrice($o['final_total']); ?></td>
            <td class="py-3">
              <select class="form-select form-select-sm bg-dark text-gold border-gold border-opacity-25 w-auto update-status font-ui small" data-id="<?php echo $o['id']; ?>">
                <option value="Placed" <?php echo $o['status'] == 'Placed' ? 'selected' : ''; ?>>Placed</option>
                <option value="Shipped" <?php echo $o['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                <option value="Delivered" <?php echo $o['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                <option value="Cancelled" <?php echo $o['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
              </select>
            </td>
            <td class="py-3 text-end">
              <a href="admin-order-detail.php?id=<?php echo $o['id']; ?>" class="btn btn-outline-gold btn-sm py-1">Details</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<script>
$(document).on('change', '.update-status', function() {
    const id = $(this).data('id');
    const status = $(this).val();
    $.post('api/admin-order-status.php', { id: id, status: status }, function(res) {
        if(res.success) {
            // Toast update
            alert('Order status updated successfully');
        }
    });
});
</script>

<?php include 'partials/footer.php'; ?>
