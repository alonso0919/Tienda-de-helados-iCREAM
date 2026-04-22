<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/sat_catalogos.php';
require_login();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis datos fiscales - EngineeringShop</title>
  <link href="css/style.css" rel="stylesheet">
  <style>
    .card-box{background:#fff;border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,.08);padding:24px}
    label{font-weight:600;margin-top:10px}
    input,select{width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:10px}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    @media(max-width:768px){.grid{grid-template-columns:1fr}}
  </style>
</head>
<body>
<?php include 'nav.php'; ?>
<div class="container" style="max-width:900px;padding:50px 15px;">
  <div class="card-box">
    <h2>Registrar datos fiscales</h2>
    <p>Guarda aquí tus datos para poder generar facturas de tus compras en modo de pruebas.</p>
    <div class="grid">
      <div><label>RFC</label><input id="rfc" maxlength="13" placeholder="XAXX010101000"></div>
      <div><label>Código postal fiscal</label><input id="tax_zip_code" maxlength="5" placeholder="64000"></div>
      <div style="grid-column:1/-1"><label>Nombre o razón social</label><input id="razon_social" placeholder="Tal como aparece en tu constancia"></div>
      <div><label>Régimen fiscal</label><select id="fiscal_regime">
        <option value="">Selecciona</option>
        <?php foreach($SAT_REGIMENES as $k => $v): ?>
          <option value="<?= htmlspecialchars($k) ?>"><?= htmlspecialchars($k . ' - ' . $v) ?></option>
        <?php endforeach; ?>
      </select></div>
      <div><label>Uso del CFDI</label><select id="cfdi_use">
        <option value="">Selecciona</option>
        <?php foreach($SAT_CFDI_USES as $k => $v): ?>
          <option value="<?= htmlspecialchars($k) ?>"><?= htmlspecialchars($k . ' - ' . $v) ?></option>
        <?php endforeach; ?>
      </select></div>
      <div style="grid-column:1/-1"><label>Email para facturas</label><input id="email" type="email" value="<?= htmlspecialchars(current_user()['email'] ?? '') ?>"></div>
    </div>
    <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap;">
      <button class="btn btn-primary" onclick="guardarDatosFiscales()">Guardar datos fiscales</button>
      <a class="btn btn-outline-primary" href="factura_tu_ticket.php">Ir a facturar una compra</a>
    </div>
    <pre id="result" style="margin-top:16px;white-space:pre-wrap;background:#fafafa;padding:12px;border-radius:10px;"></pre>
  </div>
</div>
<script>
async function guardarDatosFiscales(){
  const payload = {
    rfc: document.getElementById('rfc').value.trim().toUpperCase(),
    razon_social: document.getElementById('razon_social').value.trim(),
    tax_zip_code: document.getElementById('tax_zip_code').value.trim(),
    fiscal_regime: document.getElementById('fiscal_regime').value,
    cfdi_use: document.getElementById('cfdi_use').value,
    email: document.getElementById('email').value.trim()
  };
  const res = await fetch('../api/facturacion/registrar_cliente.php', {
    method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(payload)
  });
  const data = await res.json();
  document.getElementById('result').textContent = JSON.stringify(data, null, 2);
}
</script>
</body>
</html>
