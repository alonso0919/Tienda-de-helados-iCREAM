<?php
require_once __DIR__ . '/../config/init.php';
require_login();

$idUsuario = current_user_id();

$stmt = $conn->prepare("SELECT v.id_venta, v.total, v.fecha_venta, v.estado, t.numero_ticket, f.facturama_uuid, f.facturama_cfdi_id
FROM ventas v
LEFT JOIN tickets t ON t.id_venta = v.id_venta
LEFT JOIN facturas_emitidas f ON f.id_venta = v.id_venta
WHERE v.id_usuario = ?
ORDER BY v.fecha_venta DESC LIMIT 20");
$stmt->bind_param('i', $idUsuario);
$stmt->execute();
$ventas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Facturar compra - EngineeringShop</title>
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php'; ?>
<div class="container" style="max-width:1000px;padding:50px 15px;">
  <div class="bg-white shadow" style="border-radius:14px;padding:24px;">
    <h2>Facturar una compra</h2>
    <p>Primero registra tus datos fiscales y después genera el CFDI de una compra completada.</p>
    <p><a class="btn btn-outline-primary" href="facturacion.php">Registrar / actualizar datos fiscales</a></p>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Venta</th>
            <th>Ticket</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Factura</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($ventas as $v): ?>
          <?php $tieneFactura = !empty($v['facturama_cfdi_id']); ?>
          <tr>
            <td>#<?= (int)$v['id_venta'] ?></td>
            <td><?= htmlspecialchars($v['numero_ticket'] ?? '-') ?></td>
            <td>$<?= number_format((float)$v['total'], 2) ?></td>
            <td><?= htmlspecialchars($v['fecha_venta']) ?></td>
            <td><?= htmlspecialchars($v['estado']) ?></td>
            <td><?= !empty($v['facturama_uuid']) ? htmlspecialchars($v['facturama_uuid']) : 'Sin generar' ?></td>
            <td style="display:flex;gap:8px;flex-wrap:wrap;">
              <?php if (!$tieneFactura): ?>
                <button class="btn btn-primary btn-sm" onclick="generarFactura(<?= (int)$v['id_venta'] ?>)">Generar CFDI</button>
              <?php else: ?>
                <span class="btn btn-success btn-sm" style="pointer-events:none;opacity:.9;">CFDI generado</span>
                <a class="btn btn-info btn-sm" href="../api/facturacion/descargar_pdf.php?id_venta=<?= (int)$v['id_venta'] ?>" target="_blank" rel="noopener">Descargar PDF</a>
              <?php endif; ?>
              <button class="btn btn-secondary btn-sm" onclick="verFactura(<?= (int)$v['id_venta'] ?>)">Consultar</button>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <pre id="salida" style="white-space:pre-wrap;background:#fafafa;padding:12px;border-radius:10px;"></pre>
  </div>
</div>

<script>
async function generarFactura(idVenta){
  try {
    const res = await fetch('../api/facturacion/generar.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({id_venta:idVenta})
    });

    const text = await res.text();
    let data;
    try {
      data = JSON.parse(text);
    } catch (e) {
      document.getElementById('salida').textContent = 'Respuesta no JSON del servidor:\n\n' + text;
      return;
    }

    document.getElementById('salida').textContent = JSON.stringify(data, null, 2);

    if (data.ok) {
      alert('CFDI generado correctamente');
      window.location.reload();
    }
  } catch (err) {
    document.getElementById('salida').textContent = 'Error al generar factura: ' + err.message;
  }
}

async function verFactura(idVenta){
  try {
    const res = await fetch('../api/facturacion/obtener.php?id_venta=' + encodeURIComponent(idVenta));
    const text = await res.text();
    let data;
    try {
      data = JSON.parse(text);
    } catch (e) {
      document.getElementById('salida').textContent = 'Respuesta no JSON del servidor:\n\n' + text;
      return;
    }
    document.getElementById('salida').textContent = JSON.stringify(data, null, 2);
  } catch (err) {
    document.getElementById('salida').textContent = 'Error al consultar factura: ' + err.message;
  }
}
</script>
</body>
</html>
