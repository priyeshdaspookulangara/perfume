<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'KOEN'; ?> — Luxury Indian Oil-Based Perfume</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&family=Tenor+Sans&family=DM+Sans:wght@200;300;400;500&display=swap" rel="stylesheet">
    <!-- Chart.js (for admin pages) -->
    <?php if (strpos($_SERVER['PHP_SELF'], 'admin-') !== false): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <?php endif; ?>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <?php if (strpos($_SERVER['PHP_SELF'], 'admin-') !== false): ?>
    <link rel="stylesheet" href="css/admin.css">
    <?php endif; ?>
    <!-- jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="grain"></div>
    <div id="toast-container"></div>

    <!-- Navbar -->
    <nav id="mainNav" class="navbar navbar-expand-lg fixed-top py-3 px-4" style="background:transparent">
      <div class="container-fluid">
        <a class="navbar-brand font-display text-gold ls-wide fs-3" href="index.php">Koen</a>
        <button class="navbar-toggler border-0 text-cream" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
          <i class="bi bi-list fs-2"></i>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
          <ul class="navbar-nav mx-auto gap-lg-4">
            <li class="nav-item"><a href="shop.php" class="nav-link font-ui text-cream ls-wide small">Collection</a></li>
            <li class="nav-item"><a href="shop.php?cat=homme" class="nav-link font-ui text-cream ls-wide small">Pour Homme</a></li>
            <li class="nav-item"><a href="shop.php?cat=femme" class="nav-link font-ui text-cream ls-wide small">Pour Femme</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link font-ui text-cream ls-wide small">Atelier</a></li>
            <li class="nav-item"><a href="help.php" class="nav-link font-ui text-cream ls-wide small">Journal</a></li>
          </ul>
          <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
            <a href="account-wishlist.php" class="btn btn-link text-cream p-2"><i class="bi bi-heart fs-5"></i></a>
            <a href="account.php" class="btn btn-link text-cream p-2"><i class="bi bi-person fs-5"></i></a>
            <a href="#" class="btn btn-link text-cream position-relative p-2 cart-btn-trigger">
              <i class="bi bi-bag fs-5"></i>
              <span class="cart-badge badge bg-gold position-absolute text-dark rounded-circle" style="top:2px;right:2px;font-size:9px;<?php echo getCartCount() > 0 ? '' : 'display:none'; ?>"><?php echo getCartCount(); ?></span>
            </a>
          </div>
        </div>
      </div>
    </nav>
