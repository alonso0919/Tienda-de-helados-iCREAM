<?php require_once __DIR__ . '/../config/guard.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>iCREAM - Nuestros Servicios</title>
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
        
        /* Estilos para productos destacados en servicios */
        .featured-product {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 0;
            margin-top: 40px;
        }
        
        .featured-product .product-item {
            background: white;
            transition: transform 0.3s;
        }
        
        .featured-product .product-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
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
        
        /* Estilos para mejorar la página de servicios */
        .service-item {
            transition: transform 0.3s;
        }
        
        .service-item:hover {
            transform: translateY(-5px);
        }
        
        .page-header {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/header-bg.jpg');
            background-size: cover;
            background-position: center;
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

    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header" style="margin-bottom: 90px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-3 mt-lg-5">Nuestros Servicios</h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="index.html">Home</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">Servicios</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative mb-5">Los Mejores Servicios Para Nuestros Clientes</h1>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0 pb-5 pb-lg-0"></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel service-carousel">
                        <div class="service-item">
                            <div class="service-img mx-auto">
                                <img class="rounded-circle w-100 h-100 bg-light p-3" src="img/service-1.jpg" style="object-fit: cover;">
                            </div>
                            <div class="position-relative text-center bg-light rounded p-4 pb-5" style="margin-top: -75px;">
                                <h5 class="font-weight-semi-bold mt-5 mb-3 pt-5">Calidad Garantizada</h5>
                                <p>Mantenemos los más altos estándares de calidad en todos nuestros productos, usando ingredientes frescos y naturales.</p>
                                <a href="" class="border-bottom border-secondary text-decoration-none text-secondary">Saber Más</a>
                            </div>
                        </div>
                        <div class="service-item">
                            <div class="service-img mx-auto">
                                <img class="rounded-circle w-100 h-100 bg-light p-3" src="img/service-2.jpg" style="object-fit: cover;">
                            </div>
                            <div class="position-relative text-center bg-light rounded p-4 pb-5" style="margin-top: -75px;">
                                <h5 class="font-weight-semi-bold mt-5 mb-3 pt-5">Atención Personalizada</h5>
                                <p>Cada cliente es único, por eso ofrecemos un trato personalizado para satisfacer tus necesidades específicas.</p>
                                <a href="" class="border-bottom border-secondary text-decoration-none text-secondary">Saber Más</a>
                            </div>
                        </div>
                        <div class="service-item">
                            <div class="service-img mx-auto">
                                <img class="rounded-circle w-100 h-100 bg-light p-3" src="img/service-3.jpg" style="object-fit: cover;">
                            </div>
                            <div class="position-relative text-center bg-light rounded p-4 pb-5" style="margin-top: -75px;">
                                <h5 class="font-weight-semi-bold mt-5 mb-3 pt-5">Helados para Celebraciones</h5>
                                <p>Hacemos tus eventos especiales con nuestros deliciosos helados y postres personalizados.</p>
                                <a href="" class="border-bottom border-secondary text-decoration-none text-secondary">Saber Más</a>
                            </div>
                        </div>
                        <div class="service-item">
                            <div class="service-img mx-auto">
                                <img class="rounded-circle w-100 h-100 bg-light p-3" src="img/service-4.jpg" style="object-fit: cover;">
                            </div>
                            <div class="position-relative text-center bg-light rounded p-4 pb-5" style="margin-top: -75px;">
                                <h5 class="font-weight-semi-bold mt-5 mb-3 pt-5">Delivery a Domicilio</h5>
                                <p>Llevamos la frescura y el sabor de nuestros helados directamente a la puerta de tu casa.</p>
                                <a href="" class="border-bottom border-secondary text-decoration-none text-secondary">Saber Más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <!-- Productos Destacados Start -->
    <div class="container-fluid featured-product py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5 text-white">Productos Destacados</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 pb-2">
                    <div class="product-item d-flex flex-column align-items-center text-center bg-light rounded py-5 px-3">
                        <div class="bg-primary mt-n5 py-3" style="width: 80px;">
                            <h4 class="font-weight-bold text-white mb-0">$99</h4>
                        </div>
                        <div class="position-relative bg-primary rounded-circle mt-n3 mb-4 p-3" style="width: 150px; height: 150px;">
                            <img class="rounded-circle w-100 h-100" src="img/product-1.jpg" style="object-fit: cover;">
                        </div>
                        <h5 class="font-weight-bold mb-4">Helado de Vainilla</h5>
                        <div class="product-actions">
                            <input type="number" id="qty-service1" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Helado de Vainilla', 99, 'img/product-1.jpg', 'qty-service1')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 pb-2">
                    <div class="product-item d-flex flex-column align-items-center text-center bg-light rounded py-5 px-3">
                        <div class="bg-primary mt-n5 py-3" style="width: 80px;">
                            <h4 class="font-weight-bold text-white mb-0">$99</h4>
                        </div>
                        <div class="position-relative bg-primary rounded-circle mt-n3 mb-4 p-3" style="width: 150px; height: 150px;">
                            <img class="rounded-circle w-100 h-100" src="img/product-2.jpg" style="object-fit: cover;">
                        </div>
                        <h5 class="font-weight-bold mb-4">Helado de Fresa</h5>
                        <div class="product-actions">
                            <input type="number" id="qty-service2" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Helado de Fresa', 99, 'img/product-2.jpg', 'qty-service2')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 pb-2">
                    <div class="product-item d-flex flex-column align-items-center text-center bg-light rounded py-5 px-3">
                        <div class="bg-primary mt-n5 py-3" style="width: 80px;">
                            <h4 class="font-weight-bold text-white mb-0">$129</h4>
                        </div>
                        <div class="position-relative bg-primary rounded-circle mt-n3 mb-4 p-3" style="width: 150px; height: 150px;">
                            <img class="rounded-circle w-100 h-100" src="img/product-3.jpg" style="object-fit: cover;">
                        </div>
                        <h5 class="font-weight-bold mb-4">Helado de Menta</h5>
                        <div class="product-actions">
                            <input type="number" id="qty-service3" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Helado de Menta', 129, 'img/product-3.jpg', 'qty-service3')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 pb-2">
                    <div class="product-item d-flex flex-column align-items-center text-center bg-light rounded py-5 px-3">
                        <div class="bg-primary mt-n5 py-3" style="width: 80px;">
                            <h4 class="font-weight-bold text-white mb-0">$129</h4>
                        </div>
                        <div class="position-relative bg-primary rounded-circle mt-n3 mb-4 p-3" style="width: 150px; height: 150px;">
                            <img class="rounded-circle w-100 h-100" src="img/product-4.jpg" style="object-fit: cover;">
                        </div>
                        <h5 class="font-weight-bold mb-4">Helado de Chocolate</h5>
                        <div class="product-actions">
                            <input type="number" id="qty-service4" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Helado de Chocolate', 129, 'img/product-4.jpg', 'qty-service4')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="product.html" class="btn btn-light py-3 px-5">Ver Todos los Productos</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Productos Destacados End -->

    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5">Lo Que Dicen Nuestros Clientes</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="owl-carousel testimonial-carousel">
                        <div class="text-center">
                            <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                            <h4 class="font-weight-light mb-4">"Los mejores helados que he probado. La calidad es excepcional y el servicio de entrega es muy rápido. Definitivamente volveré a comprar."</h4>
                            <img class="img-fluid mx-auto mb-3" src="img/testimonial-1.jpg" alt="">
                            <h5 class="font-weight-bold m-0">María González</h5>
                            <span>Cliente Frecuente</span>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                            <h4 class="font-weight-light mb-4">"Increíble variedad de sabores y todos son deliciosos. El helado de menta es mi favorito. Muy recomendado."</h4>
                            <img class="img-fluid mx-auto mb-3" src="img/testimonial-2.jpg" alt="">
                            <h5 class="font-weight-bold m-0">Carlos Rodríguez</h5>
                            <span>Cliente Satisfecho</span>
                        </div>
                        <div class="text-center">
                            <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                            <h4 class="font-weight-light mb-4">"Pedí helados para la fiesta de mi hija y todos quedaron encantados. El servicio personalizado hizo la diferencia."</h4>
                            <img class="img-fluid mx-auto mb-3" src="img/testimonial-3.jpg" alt="">
                            <h5 class="font-weight-bold m-0">Ana Martínez</h5>
                            <span>Eventos Especiales</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

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