<?php
require_once __DIR__ . '/../config/init.php';

if (is_logged_in()) {
    header('Location: ' . APP_BASE . '/vistas/index.php');
    exit;
}

$error = '';
$ok = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $edad = (int)($_POST['edad'] ?? 0);

    if ($nombre === '' || $email === '' || $password === '') {
        $error = 'Nombre, email y contraseña son obligatorios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email inválido.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } else {
        // ¿ya existe?
        $stmt = $conn->prepare('SELECT id_user FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $exists = $stmt->get_result()->fetch_assoc();

        if ($exists) {
            $error = 'Ese email ya está registrado.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO usuarios (nombre, email, telefono, direccion, edad, password_hash) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('ssssis', $nombre, $email, $telefono, $direccion, $edad, $hash);
            if ($stmt->execute()) {
                $ok = 'Cuenta creada. Ya puedes iniciar sesión.';
            } else {
                $error = 'No se pudo crear la cuenta. Intenta de nuevo.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registro - iCREAM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'nav.php'; ?>

  <div class="container" style="max-width:620px; padding:60px 15px;">
    <div class="bg-white p-4 shadow" style="border-radius:12px;">
      <h2 class="mb-4">Crear cuenta</h2>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if ($ok): ?>
        <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <label>Nombre</label>
          <input class="form-control" name="nombre" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input class="form-control" type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label>Contraseña</label>
          <input class="form-control" type="password" name="password" required>
          <small class="text-muted">Mínimo 6 caracteres.</small>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Teléfono</label>
            <input class="form-control" name="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
          </div>
          <div class="form-group col-md-6">
            <label>Edad</label>
            <input class="form-control" type="number" min="0" name="edad" value="<?= htmlspecialchars($_POST['edad'] ?? '') ?>">
          </div>
        </div>
        <div class="form-group">
          <label>Dirección</label>
          <textarea class="form-control" name="direccion" rows="2"><?= htmlspecialchars($_POST['direccion'] ?? '') ?></textarea>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Registrarme</button>
      </form>

      <div class="mt-3">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="js/cart_sync.js"></script>
</body>
</html>
