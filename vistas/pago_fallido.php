<?php require_once __DIR__ . '/../config/init.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pago fallido - iCREAM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php'; ?>

<div class="container" style="max-width:760px; padding:70px 15px;">
  <div class="bg-white p-4 shadow" style="border-radius:12px;">
    <h2 class="text-danger">Pago no completado</h2>
    <p>El pago no se completó. Puedes intentarlo de nuevo desde tu carrito.</p>
    <a class="btn btn-primary" href="cart.php">Regresar al carrito</a>
  </div>
</div>

</body>
</html>
