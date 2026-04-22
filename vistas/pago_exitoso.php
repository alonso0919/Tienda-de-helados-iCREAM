<?php require_once __DIR__ . '/../config/init.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pago exitoso - iCREAM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="container" style="max-width:760px; padding:70px 15px;">
  <div class="bg-white p-4 shadow" style="border-radius:12px;">
    <h2 class="text-success">¡Pago recibido!</h2>
    <p>Tu pago fue enviado a Conekta. En unos segundos tu orden se confirmará (vía webhook) y se generará tu ticket.</p>
    <p class="text-muted">Si pagaste en efectivo o transferencia, puede tardar más en confirmarse.</p>
    <div style="display:flex;gap:10px;flex-wrap:wrap;"><a class="btn btn-primary" href="index.php">Volver al inicio</a><a class="btn btn-outline-primary" href="factura_tu_ticket.php">Facturar mi compra</a></div>
  </div>
</div>

<script>
  // Limpia carrito local y también en servidor
  localStorage.removeItem('cart');
  fetch('../api/cart.php', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({action:'clear'})});
</script>
</body>
</html>
