<?php
require_once __DIR__ . '/../config/guard.php';
// admin_productos.php
require_once __DIR__ . '/../config/conexion.php';

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] == 'agregar') {
            $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, stock, categoria, destacado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdsisi", 
                $_POST['nombre'], 
                $_POST['descripcion'], 
                $_POST['precio'], 
                $_POST['imagen'], 
                $_POST['stock'], 
                $_POST['categoria'], 
                $_POST['destacado']
            );
            $stmt->execute();
        } elseif ($_POST['accion'] == 'editar') {
            $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, imagen=?, stock=?, categoria=?, destacado=? 
                    WHERE id_producto=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdsisii", 
                $_POST['nombre'], 
                $_POST['descripcion'], 
                $_POST['precio'], 
                $_POST['imagen'], 
                $_POST['stock'], 
                $_POST['categoria'], 
                $_POST['destacado'],
                $_POST['id_producto']
            );
            $stmt->execute();
        } elseif ($_POST['accion'] == 'eliminar') {
            $sql = "DELETE FROM productos WHERE id_producto=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $_POST['id_producto']);
            $stmt->execute();
        }
    }
}

// Obtener productos
$productos = getProductos($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administración de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Administración de Productos</h1>
        
        <button class="btn btn-primary mb-3" onclick="mostrarFormulario()">Agregar Producto</button>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Destacado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $producto['id_producto']; ?></td>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td>$<?php echo $producto['precio']; ?></td>
                    <td><?php echo $producto['stock']; ?></td>
                    <td><?php echo $producto['categoria']; ?></td>
                    <td><?php echo $producto['destacado'] ? 'Sí' : 'No'; ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editarProducto(<?php echo htmlspecialchars(json_encode($producto)); ?>)">Editar</button>
                        <form method="POST" style="display:inline">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Modal para agregar/editar -->
    <div class="modal fade" id="productoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="accion" id="accion" value="agregar">
                        <input type="hidden" name="id_producto" id="id_producto">
                        
                        <div class="mb-3">
                            <label>Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label>Precio:</label>
                            <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Imagen:</label>
                            <input type="text" name="imagen" id="imagen" class="form-control" value="img/product-1.jpg">
                        </div>
                        
                        <div class="mb-3">
                            <label>Stock:</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="10" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Categoría:</label>
                            <select name="categoria" id="categoria" class="form-control">
                                <option value="Clásicos">Clásicos</option>
                                <option value="Especiales">Especiales</option>
                                <option value="Frutales">Frutales</option>
                                <option value="Premium">Premium</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label>
                                <input type="checkbox" name="destacado" id="destacado" value="1">
                                Producto Destacado
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function mostrarFormulario() {
            document.getElementById('accion').value = 'agregar';
            document.getElementById('id_producto').value = '';
            document.getElementById('nombre').value = '';
            document.getElementById('descripcion').value = '';
            document.getElementById('precio').value = '';
            document.getElementById('imagen').value = 'img/product-1.jpg';
            document.getElementById('stock').value = '10';
            document.getElementById('categoria').value = 'Clásicos';
            document.getElementById('destacado').checked = false;
            
            new bootstrap.Modal(document.getElementById('productoModal')).show();
        }
        
        function editarProducto(producto) {
            document.getElementById('accion').value = 'editar';
            document.getElementById('id_producto').value = producto.id_producto;
            document.getElementById('nombre').value = producto.nombre;
            document.getElementById('descripcion').value = producto.descripcion || '';
            document.getElementById('precio').value = producto.precio;
            document.getElementById('imagen').value = producto.imagen;
            document.getElementById('stock').value = producto.stock;
            document.getElementById('categoria').value = producto.categoria;
            document.getElementById('destacado').checked = producto.destacado == 1;
            
            new bootstrap.Modal(document.getElementById('productoModal')).show();
        }
    </script>
</body>
</html>