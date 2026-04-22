<?php
require_once __DIR__ . '/../config/init.php';

// Mantener guest_session_id para no romper carrito invitado
$guest = $_SESSION['guest_session_id'] ?? null;

$_SESSION = [];
session_destroy();

session_start();
if ($guest) {
    $_SESSION['guest_session_id'] = $guest;
}

header('Location: ' . APP_BASE . '/vistas/index.php');
exit;
