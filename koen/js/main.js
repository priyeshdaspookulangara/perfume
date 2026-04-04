// Navbar scroll
$(window).on('scroll', function() {
  $('#mainNav').toggleClass('scrolled', $(this).scrollTop() > 60);
});

// Scroll reveal
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) $(e.target).addClass('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// Cart Drawer
$('.cart-btn-trigger').on('click', function(e) {
  e.preventDefault();
  updateDrawer();
  $('#cartDrawer').css('right', '0');
  $('#drawerBackdrop').fadeIn();
});

$('#closeDrawer, #drawerBackdrop').on('click', function() {
  $('#cartDrawer').css('right', '-420px');
  $('#drawerBackdrop').fadeOut();
});

function updateDrawer() {
  $.get('partials/cart-drawer-items.php', function(html) {
    $('#drawerItems').html(html);
    updateCartStats();
  });
}

function updateCartStats() {
  $.post('api/cart-action.php', { action: 'stats' }, function(res) {
    if(res.cartCount > 0) {
      $('.cart-badge').text(res.cartCount).show();
    } else {
      $('.cart-badge').hide();
    }
    $('#drawerTotal').text('₹' + Number(res.cartTotal).toLocaleString());
  });
}

// Quick Add from Shop/Home
$(document).on('click', '.quick-add', function() {
  const p_id = $(this).data('id');
  $.ajax({
    url: 'api/cart-action.php',
    method: 'POST',
    data: { action: 'add', product_id: p_id, qty: 1 },
    success: function(res) {
      if(res.success) {
        updateDrawer();
        $('#cartDrawer').css('right', '0');
        $('#drawerBackdrop').fadeIn();
      }
    }
  });
});

// Qty modification
$(document).on('click', '.qty-minus', function() {
    const key = $(this).data('key');
    let qty = parseInt($(this).siblings('.qty-num').text());
    if(qty > 1) {
        updateQty(key, qty - 1);
    }
});

$(document).on('click', '.qty-plus', function() {
    const key = $(this).data('key');
    let qty = parseInt($(this).siblings('.qty-num').text());
    updateQty(key, qty + 1);
});

$(document).on('click', '.remove-item', function() {
    const key = $(this).data('key');
    $.post('api/cart-action.php', { action: 'remove', key: key }, function(res) {
        if(res.success) {
            updateDrawer();
            if(window.location.pathname.includes('cart.php')) location.reload();
        }
    });
});

function updateQty(key, qty) {
    $.post('api/cart-action.php', { action: 'update', key: key, qty: qty }, function(res) {
        if(res.success) {
            updateDrawer();
            if(window.location.pathname.includes('cart.php')) location.reload();
        }
    });
}
