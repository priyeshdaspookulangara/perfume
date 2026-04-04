<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$products = $conn->query("SELECT p.*, c.name as cat_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");

$page_title = 'Admin Products';
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic">Manage <em>Products</em></h2>
      <a href="admin-product-edit.php" class="btn btn-gold px-4 py-2"><i class="bi bi-plus-lg me-2"></i> ADD PRODUCT</a>
    </div>

    <div class="table-responsive">
      <table class="table table-dark table-borderless bg-transparent align-middle">
        <thead>
          <tr class="font-ui small text-gold ls-wide border-bottom border-gold border-opacity-10">
            <th class="py-3">PRODUCT</th>
            <th class="py-3">CATEGORY</th>
            <th class="py-3">PRICE</th>
            <th class="py-3">STATUS</th>
            <th class="py-3 text-end">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <?php while($p = $products->fetch_assoc()): ?>
          <tr class="font-ui small ls-wide border-bottom border-gold border-opacity-10">
            <td class="py-3">
              <div class="d-flex align-items-center gap-3">
                <img src="<?php echo e($p['image']); ?>" style="width: 40px; height: 50px; object-fit: cover;">
                <div class="font-display fs-6"><?php echo e($p['name']); ?></div>
              </div>
            </td>
            <td class="py-3 text-muted"><?php echo e($p['cat_name']); ?></td>
            <td class="py-3"><?php echo formatPrice($p['price']); ?></td>
            <td class="py-3">
              <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Active</span>
            </td>
            <td class="py-3 text-end">
              <a href="admin-product-edit.php?id=<?php echo $p['id']; ?>" class="btn btn-link text-gold p-0 me-3"><i class="bi bi-pencil"></i></a>
              <button class="btn btn-link text-danger p-0 delete-product" data-id="<?php echo $p['id']; ?>"><i class="bi bi-trash"></i></button>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>

<?php include 'partials/footer.php'; ?>
