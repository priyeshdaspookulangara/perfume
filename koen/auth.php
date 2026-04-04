<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

if (isLoggedIn()) {
    header("Location: account.php");
    exit();
}

$page_title = 'Join Koen';
include 'partials/header.php';
?>

<section class="container px-4 py-5 mt-5 min-vh-100 d-flex align-items-center justify-content-center">
  <div class="koen-card p-5 reveal w-100" style="max-width: 480px;">
    <h2 class="font-display display-5 mb-5 italic text-center">Your <em>Journey</em></h2>

    <!-- Auth Tabs -->
    <ul class="nav nav-tabs border-0 mb-5 d-flex justify-content-center gap-4" id="authTabs">
      <li class="nav-item">
        <a class="nav-link active font-ui small ls-wider text-muted-cream p-0 border-0" id="login-tab" data-bs-toggle="tab" href="#login" style="transition: color 0.3s;">LOGIN</a>
      </li>
      <li class="nav-item">
        <a class="nav-link font-ui small ls-wider text-muted-cream p-0 border-0" id="register-tab" data-bs-toggle="tab" href="#register" style="transition: color 0.3s;">REGISTER</a>
      </li>
    </ul>

    <div class="tab-content">
      <!-- Login -->
      <div class="tab-pane fade show active" id="login">
        <form action="api/login.php" method="POST" id="loginForm">
          <div class="form-floating-gold mb-4">
            <input type="email" name="email" class="koen-input" placeholder=" " required>
            <label>Email Address</label>
          </div>
          <div class="form-floating-gold mb-4">
            <input type="password" name="password" class="koen-input" placeholder=" " required>
            <label>Password</label>
          </div>

          <?php if(isset($_GET['login_error'])): ?>
            <div class="alert alert-danger font-ui small p-2 rounded-0 border-0 bg-transparent text-danger mb-4">Invalid email or password.</div>
          <?php endif; ?>

          <button type="submit" class="btn btn-gold w-100 py-3 mb-4">Sign In</button>

          <div class="text-center">
            <a href="#" class="text-muted-cream small font-ui ls-wide text-decoration-none opacity-50">Forgot password?</a>
          </div>
        </form>
      </div>

      <!-- Register -->
      <div class="tab-pane fade" id="register">
        <form action="api/register.php" method="POST" id="registerForm">
          <div class="form-floating-gold mb-4">
            <input type="text" name="name" class="koen-input" placeholder=" " required>
            <label>Full Name</label>
          </div>
          <div class="form-floating-gold mb-4">
            <input type="email" name="email" class="koen-input" placeholder=" " required>
            <label>Email Address</label>
          </div>
          <div class="form-floating-gold mb-4">
            <input type="password" name="password" class="koen-input" placeholder=" " required>
            <label>Password</label>
          </div>
          <button type="submit" class="btn btn-gold w-100 py-3 mb-4">Create Account</button>
        </form>
      </div>
    </div>

    <div class="mt-5 pt-4 border-top border-gold border-opacity-10 text-center">
      <p class="text-muted small font-ui ls-wide mb-4">OR CONTINUE WITH</p>
      <div class="d-flex justify-content-center gap-3">
        <button class="btn btn-outline-gold px-4 py-2 small ls-wide"><i class="bi bi-google me-2"></i> Google</button>
        <button class="btn btn-outline-gold px-4 py-2 small ls-wide"><i class="bi bi-facebook me-2"></i> Facebook</button>
      </div>
    </div>
  </div>
</section>

<style>
#authTabs .nav-link.active {
  color: var(--gold) !important;
  background: transparent !important;
  position: relative;
}
#authTabs .nav-link.active::after {
  content: '';
  position: absolute;
  bottom: -4px;
  left: 0;
  width: 100%;
  height: 1px;
  background: var(--gold);
}
</style>

<?php include 'partials/footer.php'; ?>
