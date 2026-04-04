<footer class="pt-5 pb-4 mt-5 border-top" style="border-color:var(--border)!important">
  <div class="container px-4">
    <div class="row g-5">
      <div class="col-lg-4">
        <h4 class="font-display text-gold mb-4 fs-3">Koen</h4>
        <p class="text-muted-cream small font-ui ls-wide lh-lg mb-4">India's premier oil-based perfume house. Distilling the essence of ancient rituals into modern classics.</p>
        <div class="d-flex gap-3">
          <a href="#" class="btn btn-outline-gold p-2 border-0"><i class="bi bi-instagram fs-5"></i></a>
          <a href="#" class="btn btn-outline-gold p-2 border-0"><i class="bi bi-facebook fs-5"></i></a>
          <a href="#" class="btn btn-outline-gold p-2 border-0"><i class="bi bi-youtube fs-5"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-4">
        <h6 class="font-ui text-gold small ls-wider mb-4">SHOP</h6>
        <ul class="list-unstyled d-flex flex-column gap-2 small font-ui ls-wide">
          <li><a href="shop.php" class="text-muted-cream text-decoration-none">All Collection</a></li>
          <li><a href="shop.php?cat=homme" class="text-muted-cream text-decoration-none">Pour Homme</a></li>
          <li><a href="shop.php?cat=femme" class="text-muted-cream text-decoration-none">Pour Femme</a></li>
          <li><a href="shop.php?cat=gifts" class="text-muted-cream text-decoration-none">Gift Sets</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-4">
        <h6 class="font-ui text-gold small ls-wider mb-4">HOUSE</h6>
        <ul class="list-unstyled d-flex flex-column gap-2 small font-ui ls-wide">
          <li><a href="about.php" class="text-muted-cream text-decoration-none">Our Story</a></li>
          <li><a href="help.php" class="text-muted-cream text-decoration-none">Sustainability</a></li>
          <li><a href="contact.php" class="text-muted-cream text-decoration-none">Boutiques</a></li>
          <li><a href="track.php" class="text-muted-cream text-decoration-none">Track Order</a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-4">
        <h6 class="font-ui text-gold small ls-wider mb-4">JOURNAL</h6>
        <p class="text-muted-cream small font-ui ls-wide mb-4">Sign up for exclusive releases and private invitations.</p>
        <div class="input-group mb-3 border-bottom border-gold" style="border-width: 1px !important;">
          <input type="email" class="form-control bg-transparent border-0 text-cream rounded-0 px-0" placeholder="EMAIL ADDRESS" style="box-shadow: none;">
          <button class="btn btn-link text-gold p-0 ms-2 text-decoration-none" type="button">JOIN</button>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top" style="border-color:var(--border)!important">
      <small class="text-muted-cream font-ui ls-wide">© 2024 KOEN INDIA. ALL RIGHTS RESERVED.</small>
      <div class="d-flex gap-4 small font-ui ls-wide">
        <a href="#" class="text-muted-cream text-decoration-none">Privacy Policy</a>
        <a href="#" class="text-muted-cream text-decoration-none">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>

<!-- Cart Drawer -->
<div id="cartDrawer" style="position:fixed;top:0;right:-420px;width:420px;max-width:100%;height:100vh;background:#0d0b07;border-left:1px solid var(--border);z-index:1060;transition:right .4s ease;overflow-y:auto">
  <div class="d-flex justify-content-between align-items-center p-4 border-bottom" style="border-color:var(--border)!important">
    <h5 class="font-display mb-0">Your Bag</h5>
    <button class="btn btn-link text-cream" id="closeDrawer"><i class="bi bi-x-lg"></i></button>
  </div>
  <div id="drawerItems" class="p-4">
    <!-- Items loaded via AJAX or PHP sessions -->
    <?php include 'cart-drawer-items.php'; ?>
  </div>
  <div class="p-4 border-top mt-auto" style="border-color:var(--border)!important">
    <div class="d-flex justify-content-between mb-3 font-display fs-5">
      <span>Subtotal</span><span class="text-gold" id="drawerTotal"><?php echo formatPrice(getCartTotal()); ?></span>
    </div>
    <a href="cart.php" class="btn btn-outline-gold w-100 mb-2">View Cart</a>
    <a href="checkout.php" class="btn btn-gold w-100">Checkout</a>
  </div>
</div>
<div id="drawerBackdrop" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1059"></div>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Main JS -->
<script src="js/main.js"></script>
</body>
</html>
