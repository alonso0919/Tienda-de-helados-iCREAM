<?php
// api/usuario.php
// Endpoint simple para consultar el usuario actual (sesión) o uno por id (admin/debug)

require_once __DIR__ . '/../config/init.php';

header('Content-Type: application/json; charset=utf-8');

function json_out($data, int $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    json_out(['ok' => false, 'error' => 'Método no permitido'], 405);
}

$usuario_id = isset($_GET['usuario_id']) ? (int)$_GET['usuario_id'] : 0;

if ($usuario_id <= 0) {
    // Por defecto: usuario en sesión
    if (!is_logged_in()) {
        json_out(['ok' => false, 'error' => 'No autenticado'], 401);
    }
    json_out(['ok' => true, 'user' => current_user()]);
}

// Buscar por id
$stmt = $conn->prepare("SELECT id_user, nombre, email, telefono, direccion, edad, fecha_registro FROM usuarios WHERE id_user = ? LIMIT 1");
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) json_out(['ok' => false, 'error' => 'Usuario no encontrado'], 404);

json_out(['ok' => true, 'user' => $row]);
?>