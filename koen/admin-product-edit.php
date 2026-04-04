<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$id = $_GET['id'] ?? 0;
$product = null;
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
}

$categories = $conn->query("SELECT * FROM categories");

$page_title = $id ? 'Edit Product' : 'Add Product';
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic"><?php echo $id ? 'Edit' : 'Add'; ?> <em>Product</em></h2>
      <a href="admin-products.php" class="text-gold font-ui small ls-wide text-decoration-none">← Back to List</a>
    </div>

    <form action="api/admin-product-save.php" method="POST" id="productEditForm">
      <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
      <input type="hidden" name="id" value="<?php echo $id; ?>">

      <div class="row g-5">
        <div class="col-lg-8">
          <div class="koen-card p-5 border-gold border">
            <h4 class="font-display fs-3 mb-5">General Information</h4>
            <div class="form-floating-gold mb-4">
              <input type="text" name="name" class="koen-input" value="<?php echo e($product['name'] ?? ''); ?>" placeholder=" " required>
              <label>Product Name</label>
            </div>
            <div class="row g-4 mb-4">
              <div class="col-md-6">
                <div class="form-floating-gold">
                  <select name="category_id" class="koen-input" style="appearance: none;" required>
                    <option value="" disabled <?php echo !$id ? 'selected' : ''; ?>>Select Category</option>
                    <?php while($c = $categories->fetch_assoc()): ?>
                      <option value="<?php echo $c['id']; ?>" <?php echo ($product['category_id'] ?? '') == $c['id'] ? 'selected' : ''; ?>><?php echo e($c['name']); ?></option>
                    <?php endwhile; ?>
                  </select>
                  <label>Category</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating-gold">
                  <input type="text" name="scent_family" class="koen-input" value="<?php echo e($product['scent_family'] ?? ''); ?>" placeholder=" " required>
                  <label>Scent Family</label>
                </div>
              </div>
            </div>
            <div class="form-floating-gold mb-4">
              <textarea name="description" class="koen-input" style="height: 150px; resize: none;" placeholder=" " required><?php echo e($product['description'] ?? ''); ?></textarea>
              <label>Full Description</label>
            </div>
            <div class="form-floating-gold mb-4">
              <textarea name="scent_story" class="koen-input" style="height: 100px; resize: none;" placeholder=" " required><?php echo e($product['scent_story'] ?? ''); ?></textarea>
              <label>Scent Story (Italicized on PDP)</label>
            </div>

            <h4 class="font-display fs-3 mb-5 mt-5">Notes Pyramid</h4>
            <div class="row g-4">
              <div class="col-md-4">
                <div class="form-floating-gold">
                  <input type="text" name="top_notes" class="koen-input" value="<?php echo e($product['top_notes'] ?? ''); ?>" placeholder=" " required>
                  <label>Top Notes</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating-gold">
                  <input type="text" name="heart_notes" class="koen-input" value="<?php echo e($product['heart_notes'] ?? ''); ?>" placeholder=" " required>
                  <label>Heart Notes</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating-gold">
                  <input type="text" name="base_notes" class="koen-input" value="<?php echo e($product['base_notes'] ?? ''); ?>" placeholder=" " required>
                  <label>Base Notes</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="koen-card p-4 border-gold border mb-4">
            <h4 class="font-display fs-3 mb-4">Pricing & Media</h4>
            <div class="form-floating-gold mb-4">
              <input type="number" name="price" class="koen-input" value="<?php echo $product['price'] ?? ''; ?>" placeholder=" " required>
              <label>Base Price (₹)</label>
            </div>
            <div class="form-floating-gold mb-4">
              <input type="number" name="compare_price" class="koen-input" value="<?php echo $product['compare_price'] ?? ''; ?>" placeholder=" ">
              <label>Compare Price (₹)</label>
            </div>
            <div class="form-floating-gold mb-4">
              <input type="text" name="badge" class="koen-input" value="<?php echo e($product['badge'] ?? ''); ?>" placeholder=" ">
              <label>Product Badge (e.g., Bestseller)</label>
            </div>
            <div class="form-floating-gold mb-4">
              <input type="url" name="image" class="koen-input" value="<?php echo e($product['image'] ?? ''); ?>" placeholder=" " required>
              <label>Main Image URL</label>
            </div>
          </div>

          <button type="submit" class="btn btn-gold w-100 py-3 mt-4">SAVE PRODUCT</button>
        </div>
      </div>
    </form>
  </main>
</div>

<?php include 'partials/footer.php'; ?>
