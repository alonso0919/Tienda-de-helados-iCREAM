<?php
// conexion.php
$host = 'localhost';
$user = 'root'; // Usuario por defecto de XAMPP
$password = ''; // Contraseña por defecto vacía en XAMPP
$database = 'engineeringstore';

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer charset
$conn->set_charset("utf8mb4");

// Función para obtener productos
function getProductos($conn, $destacados = false) {
    $sql = "SELECT * FROM productos";
    if ($destacados) {
        $sql .= " WHERE destacado = 1";
    }
    $sql .= " ORDER BY nombre";
    
    $result = $conn->query($sql);
    $productos = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }
    return $productos;
}

// Función para obtener un producto por ID
function getProductoById($conn, $id) {
    $sql = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Función para actualizar stock
function actualizarStock($conn, $id_producto, $cantidad) {
    $sql = "UPDATE productos SET stock = stock - ? WHERE id_producto = ? AND stock >= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $cantidad, $id_producto, $cantidad);
    return $stmt->execute();
}

// Función para guardar venta
function guardarVenta($conn, $carrito, $total, $datos_cliente = null) {
    // Iniciar transacción
    $conn->begin_transaction();
    
    try {
        // Insertar venta
        $sql = "INSERT INTO ventas (nombre_cliente, email_cliente, telefono_cliente, total) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $nombre = $datos_cliente['nombre'] ?? 'Cliente';
        $email = $datos_cliente['email'] ?? 'cliente@email.com';
        $telefono = $datos_cliente['telefono'] ?? '';
        $stmt->bind_param("sssd", $nombre, $email, $telefono, $total);
        $stmt->execute();
        $id_venta = $conn->insert_id;
        
        // Insertar detalles y actualizar stock
        foreach ($carrito as $item) {
            // Buscar ID del producto por nombre
            $sql_prod = "SELECT id_producto FROM productos WHERE nombre LIKE ? LIMIT 1";
            $stmt_prod = $conn->prepare($sql_prod);
            $nombre_prod = "%{$item['name']}%";
            $stmt_prod->bind_param("s", $nombre_prod);
            $stmt_prod->execute();
            $result_prod = $stmt_prod->get_result();
            $producto = $result_prod->fetch_assoc();
            
            $id_producto = $producto['id_producto'] ?? 1;
            
            // Insertar detalle
            $sql_detalle = "INSERT INTO detalle_venta (id_venta, id_producto, nombre_producto, precio_unitario, cantidad, subtotal) 
                           VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_detalle = $conn->prepare($sql_detalle);
            $subtotal = $item['price'] * $item['quantity'];
            $stmt_detalle->bind_param("iisdis", $id_venta, $id_producto, $item['name'], $item['price'], $item['quantity'], $subtotal);
            $stmt_detalle->execute();
            
            // Actualizar stock
            actualizarStock($conn, $id_producto, $item['quantity']);
        }
        
        // Generar número de ticket
        $num_ticket = 'TICKET-' . date('Ymd') . '-' . str_pad($id_venta, 5, '0', STR_PAD_LEFT);
        
        // Crear contenido del ticket
        $contenido_ticket = "=== TICKET DE COMPRA ===\n\n";
        $contenido_ticket .= "Fecha: " . date('d/m/Y H:i:s') . "\n";
        $contenido_ticket .= "Ticket N°: " . $num_ticket . "\n\n";
        $contenido_ticket .= "Productos:\n";
        $contenido_ticket .= "------------------------\n";
        
        foreach ($carrito as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $contenido_ticket .= $item['name'] . "\n";
            $contenido_ticket .= "  {$item['quantity']} x $" . number_format($item['price'], 2) . " = $" . number_format($subtotal, 2) . "\n";
        }
        
        $contenido_ticket .= "------------------------\n";
        $contenido_ticket .= "TOTAL: $" . number_format($total, 2) . "\n\n";
        $contenido_ticket .= "¡Gracias por tu compra!\n";
        $contenido_ticket .= "iCREAM - Desde 1950\n";
        
        // Guardar ticket
        $sql_ticket = "INSERT INTO tickets (id_venta, numero_ticket, contenido) VALUES (?, ?, ?)";
        $stmt_ticket = $conn->prepare($sql_ticket);
        $stmt_ticket->bind_param("iss", $id_venta, $num_ticket, $contenido_ticket);
        $stmt_ticket->execute();
        
        // Commit transacción
        $conn->commit();
        
        return [
            'success' => true,
            'id_venta' => $id_venta,
            'num_ticket' => $num_ticket,
            'contenido' => $contenido_ticket
        ];
        
    } catch (Exception $e) {
        // Rollback en caso de error
        $conn->rollback();
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
?>
<?php
// Función de prueba para verificar la inserción
function testGuardarVenta($conn) {
    $carrito_test = [
        [
            'name' => 'Helado de Vainilla',
            'price' => 99,
            'quantity' => 1,
            'image' => 'img/product-1.jpg'
        ]
    ];
    
    $total_test = 99;
    $cliente_test = [
        'nombre' => 'Cliente Test',
        'email' => 'test@test.com',
        'telefono' => '123456789'
    ];
    
    return guardarVenta($conn, $carrito_test, $total_test, $cliente_test);
}
?>
