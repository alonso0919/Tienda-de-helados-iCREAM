<?php
require_once __DIR__ . '/../config/init.php';
// Si viene next por GET, guardarlo en sesión (con límite)
if (!empty($_GET['next'])) {
    $n = (string)$_GET['next'];
    if (strlen($n) <= 1500 && str_starts_with($n, APP_BASE)) {
        $_SESSION['login_next'] = $n;
    }
}


// Si ya está logueado, manda a Home
if (is_logged_in()) {
    $dest = $_SESSION['login_next'] ?? (APP_BASE . '/vistas/index.php');
            unset($_SESSION['login_next']);
            header('Location: ' . $dest);
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
        $error = 'Ingresa email y contraseña.';
    } else {
        // usuarios: se agregará password_hash a la tabla (ver script SQL)
        $sql = "SELECT id_user, nombre, email, password_hash FROM usuarios WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();

        if (!$user || empty($user['password_hash']) || !password_verify($password, $user['password_hash'])) {
            $error = 'Credenciales inválidas.';
        } else {
            // Guardar user en sesión
            $_SESSION['user'] = [
                'id_user' => (int)$user['id_user'],
                'nombre' => $user['nombre'],
                'email' => $user['email'],
            ];

            // Si había carrito de invitado, lo “anclamos” al usuario
            require_once __DIR__ . '/../utils/cart_db.php';
            cart_attach_guest_to_user($conn, $_SESSION['guest_session_id'], (int)$user['id_user']);

            $dest = $_SESSION['login_next'] ?? (APP_BASE . '/vistas/index.php');
            unset($_SESSION['login_next']);
            header('Location: ' . $dest);
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Login - iCREAM</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include 'nav.php'; ?>

  <div class="container" style="max-width:520px; padding:60px 15px;">
    <div class="bg-white p-4 shadow" style="border-radius:12px;">
      <h2 class="mb-4">Iniciar sesión</h2>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <label>Email</label>
          <input class="form-control" type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="form-group">
          <label>Contraseña</label>
          <input class="form-control" type="password" name="password" required>
        </div>
        <button class="btn btn-primary btn-block" type="submit">Entrar</button>
      </form>

      <div class="mt-3">
        ¿No tienes cuenta? <a href="register.php">Regístrate</a>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="js/cart_sync.js"></script>
</body>
</html>
