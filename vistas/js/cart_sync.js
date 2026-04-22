// vistas/js/cart_sync.js
// Sincroniza el carrito (localStorage) con la BD vía /api/cart.php

async function syncCartToServer() {
  try {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    await fetch('../api/cart.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'set', items: cart })
    });
  } catch (e) {
    // silencioso
  }
}

// Hook: cada vez que se guarde el carrito en localStorage, lo mandamos al servidor.
(function hookLocalStorage() {
  const _setItem = localStorage.setItem;
  localStorage.setItem = function(key, value) {
    _setItem.apply(this, arguments);
    if (key === 'cart') {
      // debounce rápido
      clearTimeout(window.__cartSyncTimer);
      window.__cartSyncTimer = setTimeout(syncCartToServer, 300);
    }
  };
})();

// Última línea de defensa si cierran la pestaña
window.addEventListener('beforeunload', () => {
  try { syncCartToServer(); } catch (e) {}
});

async function loadCartFromServerIfEmpty() {
  try {
    const local = JSON.parse(localStorage.getItem('cart') || '[]');
    if (Array.isArray(local) && local.length > 0) return; // ya hay carrito local

    const res = await fetch('../api/cart.php');
    const data = await res.json();
    if (data && data.ok && Array.isArray(data.items)) {
      // Normaliza al formato del sitio
      const items = data.items.map(i => ({
        product_id: i.product_id || 0,
        name: i.name,
        price: Number(i.price),
        quantity: Number(i.quantity),
        image: i.image || ''
      }));
      localStorage.setItem('cart', JSON.stringify(items));
    }
  } catch (e) {
    // silencioso
  }
}

// Intenta recuperar carrito del servidor al cargar
document.addEventListener('DOMContentLoaded', () => {
  loadCartFromServerIfEmpty();
});
