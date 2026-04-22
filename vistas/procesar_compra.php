<?php
require_once __DIR__ . '/../config/guard.php';
// procesar_compra.php - VERSIÓN DE DEPURACIÓN
header('Content-Type: application/json');

// En producción no expongas errores al navegador.
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once __DIR__ . '/../config/conexion.php';

// Obtener datos del POST
$input = json_decode(file_get_contents('php://input'), true);

// Si no hay datos por JSON, intentar con POST normal
if (!$input) {
    $input = $_POST;
}

// Registrar para depuración
$log_file = __DIR__ . '/../debug_log.txt';
$log_data = date('Y-m-d H:i:s') . " - Datos recibidos: " . print_r($input, true) . "\n";
file_put_contents($log_file, $log_data, FILE_APPEND);

if (!$input || empty($input)) {
    echo json_encode([
        'success' => false, 
        'error' => 'No se recibieron datos',
        'debug' => 'Input vacío'
    ]);
    exit;
}

// Verificar estructura de datos
if (!isset($input['carrito']) || !isset($input['total']) || !isset($input['cliente'])) {
    echo json_encode([
        'success' => false, 
        'error' => 'Estructura de datos incorrecta',
        'debug' => $input
    ]);
    exit;
}

$carrito = $input['carrito'];
$total = $input['total'];
$cliente = $input['cliente'];

// Verificar que el carrito no está vacío
if (empty($carrito)) {
    echo json_encode(['success' => false, 'error' => 'Carrito vacío']);
    exit;
}

try {
    // Guardar venta en base de datos
    $resultado = guardarVenta($conn, $carrito, $total, $cliente);
    
    // Registrar resultado
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - Resultado: " . print_r($resultado, true) . "\n", FILE_APPEND);
    
    echo json_encode($resultado);
    
} catch (Exception $e) {
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>