<?php require_once __DIR__ . '/../config/guard.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>iCREAM - Sobre Nosotros</title>
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
        
        /* Estilos para productos destacados en About */
        .about-products-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            margin-top: 40px;
            color: white;
        }
        
        .about-product-card {
            background: white;
            border-radius: 15px;
            padding: 30px 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #333;
        }
        
        .about-product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
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
        
        .about-product-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #ff6f61;
            margin-bottom: 15px;
        }
        
        .about-product-price {
            background-color: #ff6f61;
            color: white;
            padding: 5px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        /* Estilos para la sección de historia */
        .history-section {
            background-color: #f8f9fa;
            padding: 60px 0;
            margin-top: 40px;
        }
        
        .history-year {
            font-size: 48px;
            font-weight: bold;
            color: #ff6f61;
            margin-bottom: 10px;
        }
        
        .timeline-item {
            padding: 20px;
            border-left: 3px solid #ff6f61;
            margin-bottom: 20px;
            background: white;
            border-radius: 0 10px 10px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        /* Estilos para valores */
        .value-item {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .value-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .value-icon {
            width: 80px;
            height: 80px;
            background: #ff6f61;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
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
            <h1 class="text-white display-3 mt-lg-5">Sobre Nosotros</h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="index.html">Home</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">Sobre Nosotros</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <h1 class="section-title position-relative text-center mb-5">Helados Tradicionales y Deliciosos Desde 1950</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 py-5">
                    <h4 class="font-weight-bold mb-3">Nuestra Historia</h4>
                    <h5 class="text-muted mb-3">Más de 70 años creando los helados más deliciosos con recetas tradicionales</h5>
                    <p>Desde 1950, en iCREAM nos dedicamos a crear helados artesanales con los ingredientes más frescos y naturales. Nuestra pasión por la calidad y el sabor nos ha convertido en un referente en la industria. Cada helado es elaborado siguiendo recetas tradicionales que han pasado de generación en generación.</p>
                    <a href="#history" class="btn btn-secondary mt-2">Conoce más</a>
                </div>
                <div class="col-lg-4" style="min-height: 400px;">
                    <div class="position-relative h-100 rounded overflow-hidden">
                        <img class="position-absolute w-100 h-100" src="img/about.jpg" style="object-fit: cover;" alt="Nuestra heladería tradicional">
                    </div>
                </div>
                <div class="col-lg-4 py-5">
                    <h4 class="font-weight-bold mb-3">Nuestros Valores</h4>
                    <p>En iCREAM nos guiamos por principios que garantizan la mejor experiencia para nuestros clientes:</p>
                    <h5 class="text-muted mb-3"><i class="fa fa-check text-secondary mr-3"></i>Calidad Premium</h5>
                    <h5 class="text-muted mb-3"><i class="fa fa-check text-secondary mr-3"></i>Ingredientes Naturales</h5>
                    <h5 class="text-muted mb-3"><i class="fa fa-check text-secondary mr-3"></i>Sostenibilidad</h5>
                    <a href="#values" class="btn btn-primary mt-2">Ver más</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Historia y Timeline Start -->
    <div class="container-fluid history-section" id="history">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5">Nuestra Trayectoria</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="timeline-item">
                        <div class="history-year">1950</div>
                        <h4 class="font-weight-bold">Fundación</h4>
                        <p class="text-muted">Abrimos nuestra primera heladería en el corazón de Nueva York, con una pequeña máquina de helados y grandes sueños.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="history-year">1975</div>
                        <h4 class="font-weight-bold">Expansión</h4>
                        <p class="text-muted">Comenzamos a utilizar nuestra propia leche orgánica de granjas locales, mejorando significativamente la calidad de nuestros productos.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="history-year">1990</div>
                        <h4 class="font-weight-bold">Reconocimiento</h4>
                        <p class="text-muted">Recibimos el premio al "Mejor Helado Artesanal" de Nueva York, consolidando nuestra reputación.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="timeline-item">
                        <div class="history-year">2005</div>
                        <h4 class="font-weight-bold">Innovación</h4>
                        <p class="text-muted">Introducimos nuevos sabores exóticos y opciones sin azúcar para clientes con necesidades especiales.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="history-year">2015</div>
                        <h4 class="font-weight-bold">Sostenibilidad</h4>
                        <p class="text-muted">Implementamos prácticas 100% sostenibles en nuestra producción y empaques ecológicos.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="history-year">2024</div>
                        <h4 class="font-weight-bold">Presente</h4>
                        <p class="text-muted">Seguimos creciendo y llevando felicidad a miles de clientes con nuestros deliciosos helados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Historia y Timeline End -->

    <!-- Valores Start -->
    <div class="container-fluid py-5" id="values">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5">Nuestros Valores</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Natural</h5>
                        <p class="text-muted">Usamos ingredientes 100% naturales, sin conservantes ni colorantes artificiales.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Calidad</h5>
                        <p class="text-muted">Mantenemos los más altos estándares en cada paso de nuestra producción.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Pasión</h5>
                        <p class="text-muted">Amamos lo que hacemos y se refleja en el sabor de nuestros helados.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="value-item">
                        <div class="value-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Compromiso</h5>
                        <p class="text-muted">Nos comprometemos con nuestros clientes y el medio ambiente.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Valores End -->

    <!-- Productos Destacados Start -->
    <div class="container-fluid about-products-section">
        <div class="container py-5">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5 text-white">Nuestros Productos Estrella</h1>
                    <p class="text-center text-white-50">Descubre los helados que nos han hecho famosos por más de 70 años. ¡Selecciona tu favorito!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="about-product-card">
                        <div class="about-product-price">$99</div>
                        <img src="img/product-1.jpg" alt="Helado de Vainilla" class="about-product-img">
                        <h5 class="font-weight-bold mb-3">Vainilla Clásica</h5>
                        <p class="text-muted small mb-3">Nuestra receta original de 1950, vainilla natural de Madagascar</p>
                        <div class="product-actions">
                            <input type="number" id="qty-about1" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Vainilla Clásica', 99, 'img/product-1.jpg', 'qty-about1')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="about-product-card">
                        <div class="about-product-price">$99</div>
                        <img src="img/product-2.jpg" alt="Helado de Fresa" class="about-product-img">
                        <h5 class="font-weight-bold mb-3">Fresa Silvestre</h5>
                        <p class="text-muted small mb-3">Fresas frescas cultivadas localmente, sabor intenso y natural</p>
                        <div class="product-actions">
                            <input type="number" id="qty-about2" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Fresa Silvestre', 99, 'img/product-2.jpg', 'qty-about2')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="about-product-card">
                        <div class="about-product-price">$129</div>
                        <img src="img/product-3.jpg" alt="Helado de Menta" class="about-product-img">
                        <h5 class="font-weight-bold mb-3">Menta con Chocolate</h5>
                        <p class="text-muted small mb-3">Refrescante menta con trozos de chocolate belga</p>
                        <div class="product-actions">
                            <input type="number" id="qty-about3" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Menta con Chocolate', 129, 'img/product-3.jpg', 'qty-about3')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="about-product-card">
                        <div class="about-product-price">$129</div>
                        <img src="img/product-4.jpg" alt="Helado de Chocolate" class="about-product-img">
                        <h5 class="font-weight-bold mb-3">Chocolate Belga</h5>
                        <p class="text-muted small mb-3">Chocolate 70% cacao, intenso y cremoso</p>
                        <div class="product-actions">
                            <input type="number" id="qty-about4" class="quantity-spinner" value="1" min="1" max="99">
                            <button class="btn-add-cart" onclick="addToCartWithQuantity('Chocolate Belga', 129, 'img/product-4.jpg', 'qty-about4')">
                                <i class="fas fa-cart-plus"></i> Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="product.html" class="btn btn-light py-3 px-5">
                        <i class="fas fa-ice-cream mr-2"></i> Ver Todos los Productos
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Productos Destacados End -->

    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative mb-5">Nuestros Maestros Heladeros</h1>
                    <p class="text-muted mb-4">Detrás de cada helado hay un equipo de expertos apasionados por crear experiencias únicas de sabor. Con décadas de experiencia, nuestros maestros heladeros combinan técnicas tradicionales con innovación.</p>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0 pb-5 pb-lg-0"></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel team-carousel">
                        <div class="team-item">
                            <div class="team-img mx-auto">
                                <img class="rounded-circle w-100 h-100" src="img/team-1.jpg" style="object-fit: cover;" alt="Chef Roberto">
                            </div>
                            <div class="position-relative text-center bg-light rounded px-4 py-5" style="margin-top: -100px;">
                                <h3 class="font-weight-bold mt-5 mb-3 pt-5">Roberto Conti</h3>
                                <h6 class="text-uppercase text-muted mb-4">Maestro Heladero</h6>
                                <p class="small">35 años de experiencia, especialista en sabores clásicos</p>
                                <div class="d-flex justify-content-center pt-1">
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-item">
                            <div class="team-img mx-auto">
                                <img class="rounded-circle w-100 h-100" src="img/team-2.jpg" style="object-fit: cover;" alt="Chef María">
                            </div>
                            <div class="position-relative text-center bg-light rounded px-4 py-5" style="margin-top: -100px;">
                                <h3 class="font-weight-bold mt-5 mb-3 pt-5">María Fernández</h3>
                                <h6 class="text-uppercase text-muted mb-4">Chef de Innovación</h6>
                                <p class="small">Creadora de sabores exclusivos y combinaciones únicas</p>
                                <div class="d-flex justify-content-center pt-1">
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-item">
                            <div class="team-img mx-auto">
                                <img class="rounded-circle w-100 h-100" src="img/team-3.jpg" style="object-fit: cover;" alt="Chef Giuseppe">
                            </div>
                            <div class="position-relative text-center bg-light rounded px-4 py-5" style="margin-top: -100px;">
                                <h3 class="font-weight-bold mt-5 mb-3 pt-5">Giuseppe Rossi</h3>
                                <h6 class="text-uppercase text-muted mb-4">Especialista en Helados Italianos</h6>
                                <p class="small">Tercera generación de heladeros artesanales</p>
                                <div class="d-flex justify-content-center pt-1">
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="team-item">
                            <div class="team-img mx-auto">
                                <img class="rounded-circle w-100 h-100" src="img/team-4.jpg" style="object-fit: cover;" alt="Chef Laura">
                            </div>
                            <div class="position-relative text-center bg-light rounded px-4 py-5" style="margin-top: -100px;">
                                <h3 class="font-weight-bold mt-5 mb-3 pt-5">Laura Martínez</h3>
                                <h6 class="text-uppercase text-muted mb-4">Experta en Postres</h6>
                                <p class="small">Especialista en combinaciones de helados y repostería</p>
                                <div class="d-flex justify-content-center pt-1">
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-outline-secondary btn-social mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->

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