<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

$page_title = 'Collection';
include 'partials/header.php';

// Filtering logic
$cat_slug = $_GET['cat'] ?? '';
$search = $_GET['search'] ?? '';
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 10000;
$sort = $_GET['sort'] ?? 'featured';

$query = "SELECT p.*, c.slug as cat_slug FROM products p JOIN categories c ON p.category_id = c.id WHERE 1=1";
$params = [];
$types = "";

if ($cat_slug) {
    $query .= " AND c.slug = ?";
    $params[] = $cat_slug;
    $types .= "s";
}

if ($search) {
    $query .= " AND (p.name LIKE ? OR p.description LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

$query .= " AND p.price BETWEEN ? AND ?";
$params[] = $min_price;
$params[] = $max_price;
$types .= "dd";

switch ($sort) {
    case 'price-asc': $query .= " ORDER BY p.price ASC"; break;
    case 'price-desc': $query .= " ORDER BY p.price DESC"; break;
    case 'newest': $query .= " ORDER BY p.created_at DESC"; break;
    default: $query .= " ORDER BY p.rating DESC"; break;
}

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$products = $stmt->get_result();

$categories = $conn->query("SELECT * FROM categories");
?>

<section class="container-fluid px-4 py-5 mt-5">
  <div class="row g-5">
    <!-- Sidebar -->
    <aside class="col-lg-3">
      <div class="p-4 border" style="border-color:var(--border)!important; position: sticky; top: 100px;">
        <h6 class="font-ui text-gold ls-wide small mb-4">Filter</h6>

        <form id="filterForm" action="shop.php" method="GET">
          <!-- Category -->
          <div class="mb-4">
            <p class="font-ui text-muted-cream small ls-wide mb-2">Category</p>
            <div class="form-check mb-1">
              <input class="form-check-input filter-cat" type="radio" name="cat" value="" id="catAll" <?php echo !$cat_slug ? 'checked' : ''; ?>>
              <label class="form-check-label small" for="catAll">All Collection</label>
            </div>
            <?php while($c = $categories->fetch_assoc()): ?>
            <div class="form-check mb-1">
              <input class="form-check-input filter-cat" type="radio" name="cat" value="<?php echo $c['slug']; ?>" id="cat-<?php echo $c['slug']; ?>" <?php echo $cat_slug == $c['slug'] ? 'checked' : ''; ?>>
              <label class="form-check-label small" for="cat-<?php echo $c['slug']; ?>"><?php echo $c['name']; ?></label>
            </div>
            <?php endwhile; ?>
          </div>

          <!-- Price Range -->
          <div class="mb-4">
            <p class="font-ui small ls-wide mb-2">Max Price: <span id="priceVal">₹<?php echo $max_price; ?></span></p>
            <input type="range" class="form-range" name="max_price" id="priceRange" min="0" max="10000" step="100" value="<?php echo $max_price; ?>" style="accent-color: var(--gold)">
          </div>

          <button type="submit" class="btn btn-gold w-100 btn-sm py-3 mt-3">Apply Filters</button>
          <a href="shop.php" class="text-gold small font-ui ls-wide d-block mt-4 text-center text-decoration-none">Clear All</a>
        </form>
      </div>
    </aside>

    <!-- Product Grid -->
    <main class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center mb-5">
        <small class="text-muted-cream font-ui ls-wide"><?php echo $products->num_rows; ?> products found</small>
        <div class="d-flex gap-3 align-items-center">
          <span class="small font-ui text-muted">Sort:</span>
          <select class="form-select form-select-sm bg-transparent text-cream border-0 w-auto font-ui" name="sort" form="filterForm" onchange="this.form.submit()">
            <option value="featured" <?php echo $sort == 'featured' ? 'selected' : ''; ?>>Featured</option>
            <option value="price-asc" <?php echo $sort == 'price-asc' ? 'selected' : ''; ?>>Price: Low to High</option>
            <option value="price-desc" <?php echo $sort == 'price-desc' ? 'selected' : ''; ?>>Price: High to Low</option>
            <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest</option>
          </select>
        </div>
      </div>

      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php while($p = $products->fetch_assoc()): ?>
        <div class="col">
          <div class="koen-card p-4 h-100 d-flex flex-column">
            <div class="position-relative overflow-hidden mb-4">
              <?php if($p['badge']): ?>
              <span class="badge bg-gold text-dark position-absolute top-0 start-0 m-3 z-1 font-ui small px-3"><?php echo $p['badge']; ?></span>
              <?php endif; ?>
              <a href="product.php?id=<?php echo $p['id']; ?>">
                <img src="<?php echo $p['image']; ?>" class="w-100" style="height: 350px; object-fit: cover;">
              </a>
            </div>
            <div class="flex-grow-1">
              <h5 class="font-display mb-1"><?php echo $p['name']; ?></h5>
              <p class="text-muted small font-ui ls-wide mb-3"><?php echo $p['scent_family']; ?></p>
              <div class="d-flex align-items-center justify-content-between">
                <span class="text-gold font-display fs-5"><?php echo formatPrice($p['price']); ?></span>
                <button class="btn btn-outline-gold btn-sm px-3 quick-add" data-id="<?php echo $p['id']; ?>">Add to Bag</button>
              </div>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>

      <?php if($products->num_rows == 0): ?>
      <div class="text-center py-5">
        <h3 class="font-display fst-italic text-muted">No products found matching your criteria.</h3>
      </div>
      <?php endif; ?>
    </main>
  </div>
</section>

<script>
document.getElementById('priceRange').addEventListener('input', function() {
  document.getElementById('priceVal').innerText = '₹' + this.value;
});
</script>

<?php include 'partials/footer.php'; ?>
