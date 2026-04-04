<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

if (isAdmin()) {
    header("Location: admin-dashboard.php");
    exit();
}

$page_title = 'Admin Portal';
include 'partials/header.php';
?>

<section class="container px-4 py-5 mt-5 min-vh-100 d-flex align-items-center justify-content-center">
  <div class="koen-card p-5 reveal w-100" style="max-width: 420px;">
    <div class="text-center mb-5">
        <h1 class="font-display display-5 text-gold mb-2">Koen</h1>
        <small class="font-ui ls-widest text-muted-cream opacity-50">ADMINISTRATOR PORTAL</small>
    </div>

    <form action="api/login.php" method="POST">
      <input type="hidden" name="redirect" value="../admin-dashboard.php">
      <div class="form-floating-gold mb-4">
        <input type="email" name="email" class="koen-input" id="loginEmail" placeholder=" " required>
        <label>Admin Email</label>
      </div>
      <div class="form-floating-gold mb-4">
        <input type="password" name="password" class="koen-input" id="loginPass" placeholder=" " required>
        <label>Password</label>
      </div>

      <?php if(isset($_GET['login_error'])): ?>
        <div class="alert alert-danger font-ui small p-2 rounded-0 border-0 bg-transparent text-danger mb-4 text-center">Invalid admin credentials.</div>
      <?php endif; ?>

      <button type="submit" class="btn btn-gold w-100 py-3 mb-4">AUTHENTICATE</button>

      <div class="text-center mt-3">
        <a href="index.php" class="text-muted-cream small font-ui ls-wide text-decoration-none opacity-50">Return to Storefront</a>
      </div>
    </form>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
