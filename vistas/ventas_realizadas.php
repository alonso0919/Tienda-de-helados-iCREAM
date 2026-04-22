<?php
require_once __DIR__ . '/../config/guard.php';
// ver_ventas.php
require_once __DIR__ . '/../config/conexion.php';

$sql = "SELECT v.*, COUNT(dv.id_detalle) as num_productos 
        FROM ventas v 
        LEFT JOIN detalle_venta dv ON v.id_venta = dv.id_venta 
        GROUP BY v.id_venta 
        ORDER BY v.fecha_venta DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ventas Realizadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Historial de Ventas</h1>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Productos</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_venta']; ?></td>
                    <td><?php echo $row['nombre_cliente']; ?></td>
                    <td><?php echo $row['email_cliente']; ?></td>
                    <td>$<?php echo number_format($row['total'], 2); ?></td>
                    <td><?php echo $row['num_productos']; ?></td>
                    <td><?php echo $row['fecha_venta']; ?></td>
                    <td>
                        <a href="ver_detalle_venta.php?id=<?php echo $row['id_venta']; ?>" class="btn btn-sm btn-info">Ver Detalle</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>