// Navbar scroll
$(window).on('scroll', function() {
  $('#mainNav').toggleClass('scrolled', $(this).scrollTop() > 60);
});

// Scroll reveal
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) $(e.target).addClass('visible'); });
}, { threshold: 0.08 });

function initReveal() {
  document.querySelectorAll('.reveal, .reveal-slide-right').forEach(el => revealObserver.observe(el));
}

$(document).ready(function() {
  initReveal();
  updateCartBadge();

  // Cart Drawer (Using event delegation for dynamically loaded elements)
  $(document).on('click', '#closeDrawer, #drawerBackdrop', function() {
    $('#cartDrawer').removeClass('open');
    $('#drawerBackdrop').fadeOut();
  });

  $(document).on('click', '.cart-btn-trigger', function(e) {
    e.preventDefault();
    openCartDrawer();
  });

  $(document).on('click', '#logoutBtn', function(e) {
    e.preventDefault();
    logout();
  });
});

function openCartDrawer() {
  renderDrawerItems();
  $('#cartDrawer').addClass('open');
  $('#drawerBackdrop').fadeIn();
}

// Toast system
function showToast(message, type = 'success') {
  const id = 'toast-' + Date.now();
  const html = `<div id="${id}" class="koen-toast" data-type="${type}">
    <span>${message}</span><button onclick="$('#${id}').remove()">×</button>
  </div>`;
  $('#toast-container').append(html);
  setTimeout(() => $(`#${id}`).addClass('show'), 10);
  setTimeout(() => { $(`#${id}`).removeClass('show'); setTimeout(() => $(`#${id}`).remove(), 400); }, 3000);
}

// Cart (localStorage)
function getCart() { return JSON.parse(localStorage.getItem('koen_cart') || '[]'); }
function saveCart(cart) { localStorage.setItem('koen_cart', JSON.stringify(cart)); updateCartBadge(); }
function addToCart(product) {
  let cart = getCart();
  const existing = cart.find(i => i.id === product.id && i.size === product.size);
  if (existing) existing.qty += (product.qty || 1);
  else cart.push({ ...product, qty: product.qty || 1 });
  saveCart(cart);
  showToast(`${product.name} added to cart`);
}
function updateCartBadge() {
  const total = getCart().reduce((s, i) => s + i.qty, 0);
  $('.cart-badge').text(total).toggle(total > 0);
}

function renderDrawerItems() {
  const cart = getCart();
  let html = '';
  let subtotal = 0;
  cart.forEach(item => {
    subtotal += item.price * item.qty;
    html += `
      <div class="d-flex gap-3 mb-4">
        <img src="${item.image}" style="width:60px;height:80px;object-fit:cover">
        <div class="flex-grow-1">
          <div class="font-display small">${item.name}</div>
          <div class="text-muted small">${item.size} × ${item.qty}</div>
          <div class="text-gold small">₹${(item.price * item.qty).toLocaleString()}</div>
        </div>
      </div>
    `;
  });
  if (cart.length === 0) html = '<p class="text-center text-muted py-5">Your bag is empty</p>';
  $('#drawerItems').html(html);
  $('#drawerTotal').text('₹' + subtotal.toLocaleString());
}

// Wishlist (localStorage)
function getWishlist() { return JSON.parse(localStorage.getItem('koen_wishlist') || '[]'); }
function toggleWishlist(productId, name) {
  let list = getWishlist();
  const idx = list.indexOf(productId);
  if (idx > -1) { list.splice(idx, 1); showToast(`Removed from wishlist`); }
  else { list.push(productId); showToast(`${name} saved to wishlist`); }
  localStorage.setItem('koen_wishlist', JSON.stringify(list));
  $(`.wish-btn[data-id="${productId}"]`).toggleClass('active', list.includes(productId));
}

// Auth check
function getUser() { return JSON.parse(localStorage.getItem('koen_user') || 'null'); }
function requireAuth() { if (!getUser()) { window.location.href = 'auth.html'; return false; } return true; }
function requireAdmin() { const u = getUser(); if (!u || !u.isAdmin) { window.location.href = 'admin-login.html'; return false; } return true; }

function logout() {
  localStorage.removeItem('koen_user');
  window.location.href = 'index.html';
}
