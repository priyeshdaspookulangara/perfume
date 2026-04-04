<?php
include_once 'includes/db.php';
include_once 'includes/auth.php';
include_once 'includes/functions.php';

requireAdmin();

$page_title = 'Admin Settings';
include 'partials/header.php';
?>

<div class="d-flex min-vh-100 mt-5 pt-4">
  <?php include 'partials/admin-sidebar.php'; ?>

  <main class="flex-grow-1 p-5 reveal">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h2 class="font-display display-5 mb-0 italic">Store <em>Settings</em></h2>
    </div>

    <div class="row g-5">
      <div class="col-lg-7">
        <div class="koen-card p-5 border-gold border mb-5">
          <h4 class="font-display fs-3 mb-5">General Configuration</h4>
          <form action="#" method="POST">
            <div class="form-floating-gold mb-4">
              <input type="text" class="koen-input" value="KOEN INDIA" placeholder=" ">
              <label>Store Name</label>
            </div>
            <div class="form-floating-gold mb-4">
              <input type="email" class="koen-input" value="concierge@koen.in" placeholder=" ">
              <label>Support Email</label>
            </div>
            <div class="row g-4 mb-4">
              <div class="col-md-6">
                <div class="form-floating-gold">
                  <input type="number" class="koen-input" value="799" placeholder=" ">
                  <label>Free Shipping Threshold (₹)</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating-gold">
                  <input type="number" class="koen-input" value="79" placeholder=" ">
                  <label>Standard Shipping Fee (₹)</label>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-gold px-5 py-3 mt-4">Save Configuration</button>
          </form>
        </div>

        <div class="koen-card p-5 border-gold border">
          <h4 class="font-display fs-3 mb-5">Admin Profile</h4>
          <form action="#" method="POST">
            <div class="form-floating-gold mb-4">
              <input type="text" class="koen-input" value="Administrator" placeholder=" ">
              <label>Full Name</label>
            </div>
            <div class="form-floating-gold mb-4">
              <input type="email" class="koen-input" value="admin@koen.in" placeholder=" ">
              <label>Admin Email</label>
            </div>
            <div class="form-floating-gold mb-4">
              <input type="password" class="koen-input" placeholder=" ">
              <label>Current Password</label>
            </div>
            <div class="form-floating-gold mb-4">
              <input type="password" class="koen-input" placeholder=" ">
              <label>New Password</label>
            </div>
            <button type="submit" class="btn btn-outline-gold px-5 py-3 mt-4">Update Profile</button>
          </form>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="koen-card p-4 border-gold border bg-ink bg-opacity-50">
          <h4 class="font-display fs-3 mb-4 italic">Maintenance <em>Mode</em></h4>
          <p class="text-muted-cream font-ui small ls-wide mb-4">When enabled, the storefront will be hidden from the public and show a "Coming Soon" page.</p>
          <div class="form-check form-switch custom-switch">
            <input class="form-check-input" type="checkbox" id="maintenanceMode">
            <label class="form-check-label text-cream font-ui ls-wide small ms-2" for="maintenanceMode">Maintenance Mode Enabled</label>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<style>
.custom-switch .form-check-input {
  width: 3em;
  height: 1.5em;
  background-color: var(--glass);
  border-color: var(--gold);
}
.custom-switch .form-check-input:checked {
  background-color: var(--gold);
  border-color: var(--gold);
}
</style>

<?php include 'partials/footer.php'; ?>
