<aside id="adminSidebar" class="p-4 border-end border-gold border-opacity-10" style="width: 260px; position: sticky; top: 100px; height: calc(100vh - 100px);">
  <nav class="d-flex flex-column gap-2">
    <?php $current_admin_page = basename($_SERVER['PHP_SELF']); ?>
    <a href="admin-dashboard.php" class="admin-nav-link <?php echo $current_admin_page == 'admin-dashboard.php' ? 'active' : ''; ?>"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
    <a href="admin-products.php" class="admin-nav-link <?php echo $current_admin_page == 'admin-products.php' ? 'active' : ''; ?>"><i class="bi bi-box-seam me-2"></i> Products</a>
    <a href="admin-orders.php" class="admin-nav-link <?php echo $current_admin_page == 'admin-orders.php' ? 'active' : ''; ?>"><i class="bi bi-bag-check me-2"></i> Orders</a>
    <a href="admin-customers.php" class="admin-nav-link <?php echo $current_admin_page == 'admin-customers.php' ? 'active' : ''; ?>"><i class="bi bi-people me-2"></i> Customers</a>
    <a href="admin-analytics.php" class="admin-nav-link <?php echo $current_admin_page == 'admin-analytics.php' ? 'active' : ''; ?>"><i class="bi bi-bar-chart me-2"></i> Analytics</a>
    <a href="admin-coupons.php" class="admin-nav-link <?php echo $current_admin_page == 'admin-coupons.php' ? 'active' : ''; ?>"><i class="bi bi-tag me-2"></i> Coupons</a>
    <hr class="opacity-10">
    <a href="api/logout.php" class="admin-nav-link opacity-50"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
  </nav>
</aside>

<style>
.admin-nav-link {
  padding: 14px 16px;
  color: var(--muted-cream);
  text-decoration: none;
  font-family: 'Tenor Sans';
  font-size: 11px;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  border-left: 2px solid transparent;
  transition: all 0.3s;
}
.admin-nav-link.active, .admin-nav-link:hover {
  background: var(--glass);
  color: var(--gold);
  border-left-color: var(--gold);
}
</style>
