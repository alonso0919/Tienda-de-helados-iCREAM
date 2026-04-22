<?php require_once __DIR__ . '/../config/guard.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>iCREAM - Galería de Helados</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
        
        /* Estilos para productos en la galería */
        .gallery-product-section {
            background-color: #f8f9fa;
            padding: 60px 0;
            margin-top: 40px;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }
        
        .gallery-product-item {
            background: white;
            border-radius: 10px;
            padding: 30px 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .gallery-product-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
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
            transition: background-color 0.3s;
        }
        
        .btn-add-cart:hover {
            background-color: #ff5a4a;
        }
        
        .btn-add-cart i {
            font-size: 14px;
        }
        
        .gallery-product-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #ff6f61;
            margin-bottom: 15px;
        }
        
        .gallery-product-price {
            background-color: #ff6f61;
            color: white;
            padding: 5px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .portfolio-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        
        .portfolio-item:hover .portfolio-btn {
            opacity: 1;
            transform: scale(1);
        }
        
        .portfolio-btn {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 111, 97, 0.9);
            opacity: 0;
            transition: all 0.3s ease;
            transform: scale(0);
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
                        <a class="text-white px-3" href="">Ayuda</a>
                        <span class="text-white">|</span>
                        <a class="text-white pl-3" href="">Soporte</a>
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

    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header" style="margin-bottom: 90px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-3 mt-lg-5">Galería de Helados</h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="index.html">Home</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">Galería</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Portfolio Start -->
    <div class="container-fluid py-5 px-0">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <h1 class="section-title position-relative text-center mb-5">Deliciosos Helados Hechos Con Nuestra Propia Leche Orgánica</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <ul class="list-inline mb-4 pb-2" id="portfolio-flters">
                        <li class="btn btn-sm btn-outline-primary m-1 active" data-filter="*">Todos</li>
                        <li class="btn btn-sm btn-outline-primary m-1" data-filter=".first">Cono</li>
                        <li class="btn btn-sm btn-outline-primary m-1" data-filter=".second">Vainilla</li>
                        <li class="btn btn-sm btn-outline-primary m-1" data-filter=".third">Chocolate</li>
                    </ul>
                </div>
            </div>
            <div class="row m-0 portfolio-container">
                <div class="col-lg-4 col-md-6 p-0 portfolio-item first">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/portfolio-1.jpg" alt="Cono de helado de fresa">
                        <a class="portfolio-btn" href="img/portfolio-1.jpg" data-lightbox="portfolio">
                            <i class="fa fa-plus text-primary" style="font-size: 60px;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 p-0 portfolio-item second">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/portfolio-2.jpg" alt="Helado de vainilla">
                        <a class="portfolio-btn" href="img/portfolio-2.jpg" data-lightbox="portfolio">
                            <i class="fa fa-plus text-primary" style="font-size: 60px;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 p-0 portfolio-item third">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/portfolio-3.jpg" alt="Helado de chocolate">
                        <a class="portfolio-btn" href="img/portfolio-3.jpg" data-lightbox="portfolio">
                            <i class="fa fa-plus text-primary" style="font-size: 60px;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 p-0 portfolio-item first">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/portfolio-4.jpg" alt="Cono de helado de chocolate">
                        <a class="portfolio-btn" href="img/portfolio-4.jpg" data-lightbox="portfolio">
                            <i class="fa fa-plus text-primary" style="font-size: 60px;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 p-0 portfolio-item second">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/portfolio-5.jpg" alt="Helado de fresa">
                        <a class="portfolio-btn" href="img/portfolio-5.jpg" data-lightbox="portfolio">
                            <i class="fa fa-plus text-primary" style="font-size: 60px;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 p-0 portfolio-item third">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/portfolio-6.jpg" alt="Helado de menta">
                        <a class="portfolio-btn" href="img/portfolio-6.jpg" data-lightbox="portfolio">
                            <i class="fa fa-plus text-primary" style="font-size: 60px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio End -->

    <!-- Productos Destacados en Galería Start -->
    <div class="container-fluid gallery-product-section">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5">Compra Nuestros Helados</h1>
                    <p class="text-center text-muted">Todos los helados que ves en nuestra galería están disponibles para comprar. ¡Selecciona la cantidad y agrégalos a tu carrito!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="gallery-product-item">
                        <div class="gallery-product-price">$99</div>
                        <img src="img/product-1.jpg" alt="Helado de Vainilla" class="gallery-product-img">
                        <h5 class="font-weight-bold mb-3">Helado de Vainilla</h5>
                        <p class="text-muted small mb-3">Clásico y delicioso, hecho con vainilla natural</p>
                        <div class="product-actions">
                            <input type="number" id="qty-gallery1" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Helado de Vainilla', 99, 'img/product-1.jpg', 'qty-gallery1')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="gallery-product-item">
                        <div class="gallery-product-price">$99</div>
                        <img src="img/product-2.jpg" alt="Helado de Fresa" class="gallery-product-img">
                        <h5 class="font-weight-bold mb-3">Helado de Fresa</h5>
                        <p class="text-muted small mb-3">Fresas frescas y cremosas, sabor irresistible</p>
                        <div class="product-actions">
                            <input type="number" id="qty-gallery2" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Helado de Fresa', 99, 'img/product-2.jpg', 'qty-gallery2')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="gallery-product-item">
                        <div class="gallery-product-price">$129</div>
                        <img src="img/product-3.jpg" alt="Helado de Menta" class="gallery-product-img">
                        <h5 class="font-weight-bold mb-3">Helado de Menta</h5>
                        <p class="text-muted small mb-3">Refrescante menta con trozos de chocolate</p>
                        <div class="product-actions">
                            <input type="number" id="qty-gallery3" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Helado de Menta', 129, 'img/product-3.jpg', 'qty-gallery3')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="gallery-product-item">
                        <div class="gallery-product-price">$129</div>
                        <img src="img/product-4.jpg" alt="Helado de Chocolate" class="gallery-product-img">
                        <h5 class="font-weight-bold mb-3">Helado de Chocolate</h5>
                        <p class="text-muted small mb-3">Chocolate belga, intenso y cremoso</p>
                        <div class="product-actions">
                            <input type="number" id="qty-gallery4" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Helado de Chocolate', 129, 'img/product-4.jpg', 'qty-gallery4')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="product.html" class="btn btn-primary py-3 px-5">
                        <i class="fas fa-ice-cream mr-2"></i> Ver Todos los Productos
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Productos Destacados en Galería End -->

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
                            <h5 class="font-weight-bold mb-2">Contáctanos</h5>
                            <p class="mb-2">123 Street, New York, USA</p>
                            <p class="mb-0">+012 345 67890</p>
                        </div>
                        <div class="col-sm-6 text-center text-sm-left">
                            <h5 class="font-weight-bold mb-2">Horario de Atención</h5>
                            <p class="mb-2">Lun – Sáb, 8AM – 5PM</p>
                            <p class="mb-0">Domingo: Cerrado</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="m-0">&copy; <a href="#">Domain</a>. Todos los derechos reservados. Diseñado por <a href="https://htmlcodex.com">HTML Codex</a>
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
            
            // Abrir carrito
            toggleCart();
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
            
            // Mostrar notificación
            showNotification('Producto agregado al carrito');
            
            // Abrir carrito
            toggleCart();
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
        }
        
        // Eliminar item
        function removeItem(index) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
            showNotification('Producto eliminado del carrito');
        }
        
        // Vaciar carrito
        function clearCart() {
            if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                showNotification('Carrito vaciado');
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
    </script>
    <script src="js/cart_sync.js"></script>
</body>

</html>