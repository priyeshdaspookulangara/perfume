<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

$page_title = 'Home';
include 'partials/header.php';

// Fetch featured products
$featured = $conn->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id LIMIT 4");
?>

<!-- Hero Section -->
<section class="hero position-relative vh-100 overflow-hidden">
  <div class="hero-bg" style="background: url('https://images.unsplash.com/photo-1594035910387-fea47794261f?w=1600&q=80') center/cover no-repeat; filter: brightness(0.45) saturate(0.7); position: absolute; inset: 0;"></div>
  <div class="hero-overlay-ltr" style="position: absolute; inset: 0; background: linear-gradient(to right, #090806 0%, transparent 100%);"></div>
  <div class="hero-overlay-btt" style="position: absolute; inset: 0; background: linear-gradient(to top, #090806 0%, transparent 50%);"></div>

  <div class="hero-content position-absolute bottom-0 start-0 p-5 mb-5 reveal">
    <div class="badge border border-gold text-gold rounded-pill px-3 py-2 small mb-4 ls-wide font-ui">✦ New Launch — India's No.1 Oil-Based</div>
    <h1 class="font-display display-1 mb-4">Pure / <em>Huile</em> / <br>De Parfum</h1>
    <div class="d-flex align-items-center gap-4 mb-5">
      <div class="price-strip">
        <span class="text-muted text-decoration-line-through small me-2">₹1,500</span>
        <span class="text-gold fs-2 font-display">₹899</span>
        <span class="badge bg-gold text-dark ms-3 font-ui small">Flat ₹600 Off</span>
      </div>
    </div>
    <div class="d-flex gap-3">
      <a href="shop.php" class="btn btn-gold px-5 py-3">Explore Collection</a>
      <a href="shop.php?cat=homme" class="btn btn-outline-gold px-5 py-3">Shop Pour Homme</a>
    </div>
  </div>

  <div class="hero-float-cards position-absolute end-0 top-50 translate-middle-y p-5 d-none d-lg-flex flex-column gap-3">
    <?php while($p = $featured->fetch_assoc()): ?>
    <div class="float-card p-3 reveal" style="background: rgba(9,8,6,0.75); backdrop-filter: blur(10px); border: 1px solid var(--border); min-width: 280px;">
      <div class="d-flex align-items-center gap-3">
        <img src="<?php echo $p['image']; ?>" style="width: 50px; height: 65px; object-fit: cover;">
        <div>
          <h6 class="font-display text-cream mb-1"><?php echo $p['name']; ?></h6>
          <span class="text-gold font-ui small ls-wide"><?php echo formatPrice($p['price']); ?></span>
        </div>
      </div>
    </div>
    <?php endwhile; $featured->data_seek(0); // Reset for later use ?>
  </div>
</section>

<!-- Marquee -->
<div class="overflow-hidden border-top border-bottom" style="border-color:var(--border)!important;padding:14px 0">
  <div class="marquee-track d-flex" style="animation: marquee 30s linear infinite; width:max-content">
    <?php for($i=0; $i<10; $i++): ?>
    <span class="font-ui text-gold px-4" style="letter-spacing:.28em;font-size:10.5px;opacity:.65">Long Lasting <span class="mx-2 opacity-50">·</span></span>
    <span class="font-ui text-gold px-4" style="letter-spacing:.28em;font-size:10.5px;opacity:.65">Alcohol Free <span class="mx-2 opacity-50">·</span></span>
    <span class="font-ui text-gold px-4" style="letter-spacing:.28em;font-size:10.5px;opacity:.65">Artisan Craft <span class="mx-2 opacity-50">·</span></span>
    <?php endfor; ?>
  </div>
</div>

<!-- Featured Products -->
<section class="container-fluid px-4 py-5 mt-5">
  <div class="d-flex justify-content-between align-items-end mb-5 reveal">
    <div>
      <span class="section-label mb-2">Curated Classics</span>
      <h2 class="font-display display-4">Featured <em>Collection</em></h2>
    </div>
    <a href="shop.php" class="text-gold font-ui small ls-wide text-decoration-none border-bottom border-gold pb-1">View All</a>
  </div>

  <div class="row g-0 reveal">
    <?php while($p = $featured->fetch_assoc()): ?>
    <div class="col-lg-3 col-md-6">
      <div class="koen-card p-4 h-100 d-flex flex-column">
        <div class="position-relative overflow-hidden mb-4">
          <?php if($p['badge']): ?>
          <span class="badge bg-gold text-dark position-absolute top-0 start-0 m-3 z-1 font-ui small px-3"><?php echo $p['badge']; ?></span>
          <?php endif; ?>
          <a href="product.php?id=<?php echo $p['id']; ?>">
            <img src="<?php echo $p['image']; ?>" class="w-100" style="height: 400px; object-fit: cover;">
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
</section>

<!-- Gender Split -->
<section class="container-fluid px-0 py-5">
  <div class="row g-0">
    <div class="col-md-6 vh-75 position-relative overflow-hidden reveal">
      <div class="split-bg h-100" style="background: url('https://images.unsplash.com/photo-1594035910387-fea47794261f?w=1000&q=80') center/cover no-repeat; transition: transform 0.8s;"></div>
      <div class="position-absolute inset-0 bg-dark opacity-25"></div>
      <div class="position-absolute bottom-0 start-0 p-5">
        <span class="section-label text-white mb-2">Strength & Grace</span>
        <h3 class="font-display display-5 text-white mb-4">Pour <em>Homme</em></h3>
        <a href="shop.php?cat=homme" class="btn btn-gold px-4">Discover</a>
      </div>
    </div>
    <div class="col-md-6 vh-75 position-relative overflow-hidden reveal">
      <div class="split-bg h-100" style="background: url('https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=1000&q=80') center/cover no-repeat; transition: transform 0.8s;"></div>
      <div class="position-absolute inset-0 bg-dark opacity-25"></div>
      <div class="position-absolute bottom-0 start-0 p-5">
        <span class="section-label text-white mb-2">Elegance & Charm</span>
        <h3 class="font-display display-5 text-white mb-4">Pour <em>Femme</em></h3>
        <a href="shop.php?cat=femme" class="btn btn-gold px-4">Discover</a>
      </div>
    </div>
  </div>
</section>

<!-- Philosophy -->
<section class="container-fluid px-0 py-5">
  <div class="row g-0 align-items-stretch reveal">
    <div class="col-lg-6">
      <img src="https://images.unsplash.com/photo-1557170334-a9632e77c6e4?w=1200&q=80" class="w-100 h-100 object-fit-cover">
    </div>
    <div class="col-lg-6 p-5 d-flex flex-column justify-content-center" style="background: #080604;">
      <span class="section-label mb-4">The Atelier</span>
      <h2 class="font-display display-5 mb-4 italic">"True perfume is an <em>incantation</em>, a bridge between the physical and the sublime."</h2>
      <p class="text-muted-cream font-ui ls-wide lh-lg mb-5">At Koen, we return to the roots of Indian perfumery—the oil-based 'attar'. Free from alcohol, each drop is a concentrated essence that interacts with your body heat, creating a scent that is uniquely yours and lasts from dawn to dusk.</p>
      <div class="row g-4 border-top border-bottom py-5" style="border-color: var(--border) !important;">
        <div class="col-4">
          <div class="font-display fs-2 text-gold">100%</div>
          <div class="font-ui small ls-wide text-muted">Pure Oils</div>
        </div>
        <div class="col-4">
          <div class="font-display fs-2 text-gold">12h+</div>
          <div class="font-ui small ls-wide text-muted">Longevity</div>
        </div>
        <div class="col-4">
          <div class="font-display fs-2 text-gold">Hand</div>
          <div class="font-ui small ls-wide text-muted">Blended</div>
        </div>
      </div>
      <a href="about.php" class="btn btn-outline-gold mt-5 align-self-start px-5">Our Story</a>
    </div>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
