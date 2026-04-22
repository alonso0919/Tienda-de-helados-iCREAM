<?php require_once __DIR__ . '/../config/guard.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Mi Carrito - iCREAM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <!-- <link href="img/favicon.ico" rel="icon"> -->

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        /* Estilos para el carrito */
        .cart-icon {
            position: relative;
            cursor: pointer;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ff6f61;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .cart-sidebar {
            position: fixed;
            right: -400px;
            top: 0;
            width: 400px;
            height: 100%;
            background-color: white;
            box-shadow: -2px 0 5px rgba(0,0,0,0.2);
            transition: right 0.3s ease;
            z-index: 9999;
            overflow-y: auto;
        }
        
        .cart-sidebar.open {
            right: 0;
        }
        
        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            display: none;
            z-index: 9998;
        }
        
        .cart-overlay.active {
            display: block;
        }
        
        .cart-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .cart-items {
            padding: 20px;
        }
        
        .cart-item {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            color: #ff6f61;
            font-weight: bold;
        }
        
        .cart-item-quantity {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        
        .qty-btn {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 5px 10px;
            cursor: pointer;
        }
        
        .qty-value {
            padding: 5px 15px;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
        
        .cart-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background-color: white;
            border-top: 2px solid #eee;
        }
        
        .cart-total {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .remove-item {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 18px;
        }
        
        .empty-cart {
            text-align: center;
            padding: 50px 20px;
            color: #999;
        }
        
        .empty-cart i {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        /* Estilos para los controles de cantidad */
        .product-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            width: 100%;
            justify-content: center;
        }
        
        .quantity-spinner {
            width: 70px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        
        .btn-add-cart {
            background-color: #ff6f61;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }
        
        .btn-add-cart:hover {
            background-color: #ff5a4a;
        }
        
        .btn-add-cart i {
            font-size: 14px;
        }
        
        /* Estilos para la página del carrito */
        .cart-page {
            min-height: 500px;
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        
        .cart-table th {
            background-color: #343a40;
            color: white;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
        }
        
        .cart-table td {
            padding: 20px 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
            background-color: white;
        }
        
        .cart-product-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ff6f61;
        }
        
        .cart-product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .cart-product-details {
            display: flex;
            flex-direction: column;
        }
        
        .cart-product-name {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 16px;
        }
        
        .cart-product-price {
            color: #ff6f61;
            font-weight: 600;
        }
        
        .cart-quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-quantity-input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        
        .cart-summary {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            position: sticky;
            top: 20px;
        }
        
        .cart-summary-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ff6f61;
            color: #343a40;
        }
        
        .cart-summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .cart-summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            font-size: 20px;
            font-weight: bold;
            color: #ff6f61;
        }
        
        .btn-checkout {
            width: 100%;
            padding: 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 25px;
            transition: background-color 0.3s;
        }
        
        .btn-checkout:hover {
            background-color: #218838;
        }
        
        .btn-clear-cart {
            width: 100%;
            padding: 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        
        .btn-clear-cart:hover {
            background-color: #c82333;
        }
        
        .continue-shopping {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        
        .continue-shopping:hover {
            text-decoration: underline;
            color: #0056b3;
        }
        
        .empty-cart-page {
            text-align: center;
            padding: 80px 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        
        .empty-cart-page i {
            font-size: 100px;
            color: #dee2e6;
            margin-bottom: 30px;
        }
        
        .empty-cart-page h3 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #343a40;
        }
        
        .empty-cart-page p {
            color: #6c757d;
            margin-bottom: 30px;
            font-size: 18px;
        }
        
        .btn-primary {
            background-color: #ff6f61;
            border-color: #ff6f61;
            padding: 12px 30px;
            font-size: 18px;
        }
        
        .btn-primary:hover {
            background-color: #ff5a4a;
            border-color: #ff5a4a;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-primary py-3 d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-lg-left mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-white pr-3" href="">FAQs</a>
                        <span class="text-white">|</span>
                        <a class="text-white px-3" href="">Help</a>
                        <span class="text-white">|</span>
                        <a class="text-white pl-3" href="">Support</a>
                    </div>
                </div>
                <div class="col-md-6 text-center text-lg-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-white px-3" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-white px-3" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-white px-3" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-white px-3" href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-white pl-3" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

     <?php include("nav.php");
                                     ?>

    <!-- Cart Overlay -->
    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h4>Tu Carrito</h4>
            <button class="btn btn-link" onclick="toggleCart()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="cart-items" id="cartItems">
            <!-- Items del carrito se agregarán aquí dinámicamente -->
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotal">$0</span>
            </div>
            <button class="btn btn-primary btn-block" onclick="window.location.href='cart.html'">Ver Carrito</button>
            <button class="btn btn-outline-secondary btn-block" onclick="clearCart()">Vaciar Carrito</button>
        </div>
    </div>

    <!-- Cart Page Content -->
    <div id="cartPageContainer" class="container-fluid py-5">
        <!-- El contenido se cargará dinámicamente -->
    </div>

    <!-- Footer Start -->
    <div class="container-fluid footer bg-light py-5" style="margin-top: 90px;">
        <div class="container text-center py-5">
            <div class="row">
                <div class="col-12 mb-4">
                    <a href="index.html" class="navbar-brand m-0">
                        <h1 class="m-0 mt-n2 display-4 text-primary"><span class="text-secondary">i</span>CREAM</h1>
                    </a>
                </div>
                <div class="col-12 mb-4">
                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-secondary btn-social" href="#"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="col-12 mt-2 mb-4">
                    <div class="row">
                        <div class="col-sm-6 text-center text-sm-right border-right mb-3 mb-sm-0">
                            <h5 class="font-weight-bold mb-2">Get In Touch</h5>
                            <p class="mb-2">123 Street, New York, USA</p>
                            <p class="mb-0">+012 345 67890</p>
                        </div>
                        <div class="col-sm-6 text-center text-sm-left">
                            <h5 class="font-weight-bold mb-2">Opening Hours</h5>
                            <p class="mb-2">Mon – Sat, 8AM – 5PM</p>
                            <p class="mb-0">Sunday: Closed</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="m-0">&copy; <a href="#">Domain</a>. All Rights Reserved. Designed by <a href="https://htmlcodex.com">HTML Codex</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary px-2 back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    
    <!-- Cart Functionality -->
    <script>
        // Carrito de compras
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        // Inicializar carrito al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            updateCartUI();
            displayCartPage();
        });
        
        // Agregar producto al carrito con cantidad específica
        function addToCartWithQuantity(name, price, image, inputId) {
            const quantityInput = document.getElementById(inputId);
            const quantity = parseInt(quantityInput.value) || 1;
            
            // Buscar si el producto ya existe
            const existingItem = cart.find(item => item.name === name);
            
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({
                    name: name,
                    price: price,
                    image: image,
                    quantity: quantity
                });
            }
            
            // Guardar en localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Actualizar UI
            updateCartUI();
            
            // Resetear cantidad a 1
            quantityInput.value = 1;
            
            // Mostrar notificación
            showNotification(`${quantity} ${quantity === 1 ? 'producto' : 'productos'} agregado${quantity === 1 ? '' : 's'} al carrito`);
        }
        
        // Agregar producto al carrito (versión original para compatibilidad)
        function addToCart(name, price, image) {
            // Buscar si el producto ya existe
            const existingItem = cart.find(item => item.name === name);
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    name: name,
                    price: price,
                    image: image,
                    quantity: 1
                });
            }
            
            // Guardar en localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Actualizar UI
            updateCartUI();
            
            // Abrir carrito
            toggleCart();
            
            // Mostrar notificación
            showNotification('Producto agregado al carrito');
        }
        
        // Actualizar interfaz del carrito
        function updateCartUI() {
            const cartCount = document.getElementById('cartCount');
            const cartItems = document.getElementById('cartItems');
            const cartTotal = document.getElementById('cartTotal');
            
            // Actualizar contador
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            if (cartCount) {
                cartCount.textContent = totalItems;
            }
            
            // Actualizar items del sidebar
            if (cartItems) {
                if (cart.length === 0) {
                    cartItems.innerHTML = `
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Tu carrito está vacío</p>
                        </div>
                    `;
                } else {
                    cartItems.innerHTML = cart.map((item, index) => `
                        <div class="cart-item">
                            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                            <div class="cart-item-details">
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-price">$${item.price}</div>
                                <div class="cart-item-quantity">
                                    <button class="qty-btn" onclick="updateQuantity(${index}, -1)">-</button>
                                    <span class="qty-value">${item.quantity}</span>
                                    <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                                </div>
                            </div>
                            <button class="remove-item" onclick="removeItem(${index})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `).join('');
                }
            }
            
            // Actualizar total
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            if (cartTotal) {
                cartTotal.textContent = `$${total}`;
            }
        }
        
        // Actualizar cantidad
        function updateQuantity(index, change) {
            cart[index].quantity += change;
            
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
            
            // Actualizar la página del carrito
            displayCartPage();
        }
        
        // Eliminar item
        function removeItem(index) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
            showNotification('Producto eliminado del carrito');
            
            // Actualizar la página del carrito
            displayCartPage();
        }
        
        // Vaciar carrito
        function clearCart() {
            if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                showNotification('Carrito vaciado');
                
                // Actualizar la página del carrito
                displayCartPage();
            }
        }
        
        // Toggle carrito
        function toggleCart() {
            const sidebar = document.getElementById('cartSidebar');
            const overlay = document.getElementById('cartOverlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }
        
        // Mostrar notificación
        function showNotification(message) {
            // Crear elemento de notificación
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #28a745;
                color: white;
                padding: 15px 20px;
                border-radius: 5px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                z-index: 10000;
                animation: slideIn 0.3s ease;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Eliminar después de 3 segundos
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
        // Función para mostrar la página del carrito
        function displayCartPage() {
            const cartPageContainer = document.getElementById('cartPageContainer');
            if (!cartPageContainer) return;
            
            if (cart.length === 0) {
                cartPageContainer.innerHTML = `
                    <div class="container cart-page">
                        <div class="empty-cart-page">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Tu carrito está vacío</h3>
                            <p class="text-muted">Parece que aún no has agregado productos a tu carrito.</p>
                            <a href="index.html#products" class="btn btn-primary">
                                <i class="fas fa-ice-cream"></i> Ver Productos
                            </a>
                        </div>
                    </div>
                `;
                return;
            }
            
            let html = `
                <div class="container cart-page">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h2 class="display-5">Mi Carrito de Compras</h2>
                            <p class="text-muted">Tienes ${cart.reduce((sum, item) => sum + item.quantity, 0)} productos en tu carrito</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="cart-table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
            `;
            
            cart.forEach((item, index) => {
                const subtotal = item.price * item.quantity;
                html += `
                    <tr>
                        <td>
                            <div class="cart-product-info">
                                <img src="${item.image}" alt="${item.name}" class="cart-product-img">
                                <div class="cart-product-details">
                                    <span class="cart-product-name">${item.name}</span>
                                    <span class="cart-product-price">$${item.price}</span>
                                </div>
                            </div>
                        </td>
                        <td><strong>$${item.price}</strong></td>
                        <td>
                            <div class="cart-quantity-control">
                                <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${index}, -1)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="cart-quantity-input" value="${item.quantity}" min="1" onchange="updateCartQuantity(${index}, this.value)">
                                <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${index}, 1)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </td>
                        <td><strong class="text-primary">$${subtotal}</strong></td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="removeItem(${index})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const envio = 0;
            const total = subtotal + envio;
            
            html += `
                                    </tbody>
                                </table>
                            </div>
                            <a href="index.html#products" class="continue-shopping">
                                <i class="fas fa-arrow-left"></i> Continuar Comprando
                            </a>
                        </div>
                        <div class="col-lg-4">
                            <div class="cart-summary">
                                <h5 class="cart-summary-title">Resumen del Pedido</h5>
                                <div class="cart-summary-item">
                                    <span>Subtotal:</span>
                                    <span><strong>$${subtotal}</strong></span>
                                </div>
                                <div class="cart-summary-item">
                                    <span>Envío:</span>
                                    <span><strong class="text-success">Gratis</strong></span>
                                </div>
                                <div class="cart-summary-total">
                                    <span>Total:</span>
                                    <span>$${total}</span>
                                </div>
                                <button class="btn-checkout" onclick="checkout()">
                                    <i class="fas fa-lock"></i> Proceder al Pago
                                </button>
                                <button class="btn-clear-cart" onclick="clearCart()">
                                    <i class="fas fa-trash-alt"></i> Vaciar Carrito
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            cartPageContainer.innerHTML = html;
        }
        
        // Actualizar cantidad desde input
        function updateCartQuantity(index, value) {
            const quantity = parseInt(value);
            if (quantity > 0) {
                cart[index].quantity = quantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                displayCartPage();
                showNotification('Cantidad actualizada');
            }
        }
        
        // Proceder al pago (Conekta Hosted Checkout)
        async function checkout() {
            if (cart.length === 0) {
                alert('Tu carrito está vacío');
                return;
            }

            try {
                const res = await fetch('../api/conekta_checkout.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        carrito: cart
                    })
                });
                const data = await res.json();
                if (!data.ok) {
                    console.error(data);
                    alert(
                      'No se pudo iniciar el pago:\n' +
                      (data.error || 'Error') + '\n\n' +
                      JSON.stringify(data.detail || {}, null, 2)
                  );
                  return;
                }

                // Redirige al checkout seguro de Conekta
                window.location.href = data.checkout_url;
            } catch (e) {
                alert('Error al iniciar pago. Revisa consola.');
                console.error(e);
            }
        }
    </script>
    <script src="js/cart_sync.js"></script>
</body>

</html>