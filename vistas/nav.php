<?php
// nav.php
require_once __DIR__ . '/../config/init.php';
$user = current_user();
?>
<!-- Navbar Start -->
<!-- Navbar Start -->
<div class="container-fluid position-relative nav-bar p-0">
    <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow p-lg-0 position-relative">
            <a href="index.php" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-4 text-primary"><span class="text-secondary">i</span>CREAM</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="w-100 d-flex align-items-center">

                <div class="navbar-nav ml-auto py-0">
                    <a href="index.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a>
                    <a href="about.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a>
                    <a href="product.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'product.php' ? 'active' : ''; ?>">Product</a>
                </div>
                <!--
                  Brand centrado: lo hacemos absoluto y centrado para que quede realmente al centro
                  (sin depender de mx-5 que a veces lo desplaza).
                -->
                <a href="index.php" class="navbar-brand mx-auto d-none d-lg-block text-center">
                <h1 class="m-0 display-4 text-primary"><span class="text-secondary">i</span>CREAM</h1>
                </a>

                <div class="navbar-nav mr-auto py-0">
                    <a href="service.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'service.php' ? 'active' : ''; ?>">Service</a>
                    <a href="gallery.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : ''; ?>">Gallery</a>
                    <a href="cart.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : ''; ?>">Carrito</a>

                    <?php if ($user): ?>
                        <span class="nav-item nav-link" style="cursor:default;">
                            <i class="fas fa-user"></i> <?= htmlspecialchars($user['nombre']) ?>
                        </span>
                        <a href="logout.php" class="nav-item nav-link">Salir</a>
                    <?php else: ?>
                        <a href="login.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>">Login</a>
                        <a href="register.php" class="nav-item nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>">Registro</a>
                    <?php endif; ?>

                    <a href="javascript:void(0)" class="nav-item nav-link cart-icon" onclick="toggleCart()">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count" id="cartCount">0</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
    <!-- Navbar End -->