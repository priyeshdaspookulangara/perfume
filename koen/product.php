<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

$p_id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->bind_param("i", $p_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header("Location: shop.php");
    exit();
}

$page_title = $product['name'];
include 'partials/header.php';

// Fetch sizes
$sizes_res = $conn->query("SELECT * FROM product_sizes WHERE product_id = $p_id ORDER BY ml ASC");
$sizes = [];
while($row = $sizes_res->fetch_assoc()) $sizes[] = $row;

// Fetch gallery
$images_res = $conn->query("SELECT * FROM product_images WHERE product_id = $p_id");
$images = [];
while($row = $images_res->fetch_assoc()) $images[] = $row;
if (empty($images)) $images[] = ['image_url' => $product['image']];
?>

<section class="container-fluid px-4 py-5 mt-5">
  <nav aria-label="breadcrumb" class="mb-5">
    <ol class="breadcrumb font-ui small ls-wide">
      <li class="breadcrumb-item"><a href="index.php" class="text-muted text-decoration-none">Home</a></li>
      <li class="breadcrumb-item"><a href="shop.php" class="text-muted text-decoration-none">Collection</a></li>
      <li class="breadcrumb-item text-gold active"><?php echo e($product['name']); ?></li>
    </ol>
  </nav>

  <div class="row g-5">
    <!-- Gallery -->
    <div class="col-lg-6">
      <div class="position-sticky top-100">
        <div class="main-img-container mb-3 overflow-hidden">
          <img id="mainImg" src="<?php echo e($images[0]['image_url']); ?>" class="w-100 reveal" style="height: 600px; object-fit: cover;">
        </div>
        <div class="d-flex gap-2">
          <?php foreach($images as $img): ?>
          <img src="<?php echo e($img['image_url']); ?>" class="thumb-img reveal" style="width: 80px; height: 100px; object-fit: cover; cursor: pointer; border: 1px solid transparent; transition: all 0.3s;" data-src="<?php echo e($img['image_url']); ?>">
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Product Info -->
    <div class="col-lg-6 p-lg-5">
      <span class="badge border border-gold text-gold rounded-pill px-3 py-2 small mb-4 ls-wide font-ui"><?php echo e($product['scent_family']); ?></span>
      <h1 class="font-display display-3 mb-3 reveal"><?php echo e($product['name']); ?></h1>
      <div class="d-flex align-items-center gap-3 mb-4 reveal">
        <div class="text-gold">
          <?php
          for($i=0; $i<5; $i++) {
              if($i < floor($product['rating'])) echo '<i class="bi bi-star-fill"></i>';
              else echo '<i class="bi bi-star text-muted"></i>';
          }
          ?>
        </div>
        <small class="text-muted-cream font-ui ls-wide">(<?php echo e($product['review_count']); ?> reviews)</small>
      </div>

      <div class="price-block mb-5 reveal">
        <span class="text-gold display-5 font-display" id="currentPrice"><?php echo formatPrice($product['price']); ?></span>
        <?php if($product['compare_price']): ?>
        <span class="text-muted text-decoration-line-through fs-4 ms-3 font-display"><?php echo formatPrice($product['compare_price']); ?></span>
        <?php endif; ?>
      </div>

      <hr style="border-color: var(--border) !important;">

      <div class="scent-story my-5 reveal">
        <blockquote class="font-display fs-4 fst-italic text-muted-cream mb-0">"<?php echo e($product['scent_story']); ?>"</blockquote>
      </div>

      <!-- Notes Pyramid -->
      <div class="row g-4 mb-5 reveal">
        <div class="col-4">
          <h6 class="font-ui text-gold small ls-wider mb-2">TOP</h6>
          <p class="small text-muted-cream mb-0"><?php echo e($product['top_notes']); ?></p>
        </div>
        <div class="col-4">
          <h6 class="font-ui text-gold small ls-wider mb-2">HEART</h6>
          <p class="small text-muted-cream mb-0"><?php echo e($product['heart_notes']); ?></p>
        </div>
        <div class="col-4">
          <h6 class="font-ui text-gold small ls-wider mb-2">BASE</h6>
          <p class="small text-muted-cream mb-0"><?php echo e($product['base_notes']); ?></p>
        </div>
      </div>

      <!-- Size Selector -->
      <div class="size-selector mb-5 reveal">
        <p class="font-ui text-muted small ls-wide mb-3">SELECT SIZE</p>
        <div class="d-flex gap-3" id="sizeSelector">
          <?php foreach($sizes as $idx => $s): ?>
          <button class="btn btn-outline-gold size-btn flex-fill py-3 <?php echo $idx==1 || (count($sizes)==1 && $idx==0) ? 'active' : ''; ?>"
                  data-ml="<?php echo e($s['ml']); ?>"
                  data-id="<?php echo e($s['id']); ?>"
                  data-price="<?php echo e($s['price']); ?>">
            <?php echo e($s['ml']); ?>ml — <?php echo formatPrice($s['price']); ?>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Quantity and Add to Cart -->
      <div class="row g-3 reveal mb-5">
        <div class="col-md-3">
          <div class="d-flex align-items-center h-100 border border-gold">
            <button class="btn btn-link text-cream text-decoration-none px-3 py-2" id="qtyMinus"><i class="bi bi-dash"></i></button>
            <span class="flex-grow-1 text-center font-ui" id="qtyNum">1</span>
            <button class="btn btn-link text-cream text-decoration-none px-3 py-2" id="qtyPlus"><i class="bi bi-plus"></i></button>
          </div>
        </div>
        <div class="col-md-9">
          <button class="btn btn-gold w-100 h-100 py-3" id="addToCartBtn" data-id="<?php echo e($product['id']); ?>">Add to Bag</button>
        </div>
      </div>

      <!-- Accordion -->
      <div class="accordion accordion-flush border-top border-bottom reveal" id="pdpAccordion" style="border-color: var(--border) !important;">
        <div class="accordion-item bg-transparent">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-transparent text-cream font-display fs-5 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#descCollapse">
              Description
            </button>
          </h2>
          <div id="descCollapse" class="accordion-collapse collapse" data-bs-parent="#pdpAccordion">
            <div class="accordion-body text-muted-cream small font-ui ls-wide lh-lg px-0">
              <?php echo e($product['description']); ?>
            </div>
          </div>
        </div>
        <div class="accordion-item bg-transparent">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-transparent text-cream font-display fs-5 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#shippingCollapse">
              Shipping & Returns
            </button>
          </h2>
          <div id="shippingCollapse" class="accordion-collapse collapse" data-bs-parent="#pdpAccordion">
            <div class="accordion-body text-muted-cream small font-ui ls-wide lh-lg px-0">
              Complimentary shipping on orders above ₹799. Delivery typically within 3-5 business days across India. Due to hygiene reasons, we do not accept returns on opened perfumes.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  $('.thumb-img').on('click', function() {
    const src = $(this).data('src');
    $('#mainImg').fadeOut(200, function() {
      $(this).attr('src', src).fadeIn(200);
    });
    $('.thumb-img').css('border-color', 'transparent');
    $(this).css('border-color', 'var(--gold)');
  });

  $('.size-btn').on('click', function() {
    $('.size-btn').removeClass('active');
    $(this).addClass('active');
    const price = $(this).data('price');
    $('#currentPrice').text('₹' + Number(price).toLocaleString());
  });

  let qty = 1;
  $('#qtyMinus').on('click', () => { if(qty > 1) { qty--; $('#qtyNum').text(qty); } });
  $('#qtyPlus').on('click', () => { qty++; $('#qtyNum').text(qty); });

  $('#addToCartBtn').on('click', function() {
    const p_id = $(this).data('id');
    const s_id = $('.size-btn.active').data('id');

    $.ajax({
      url: 'api/cart-action.php',
      method: 'POST',
      data: { action: 'add', product_id: p_id, size_id: s_id, qty: qty },
      success: function(res) {
        if(res.success) {
          updateDrawer();
          $('#cartDrawer').css('right', '0');
          $('#drawerBackdrop').fadeIn();
        }
      }
    });
  });
});
</script>

<?php include 'partials/footer.php'; ?>
