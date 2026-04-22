<?php
// Copia este archivo sobre config/conexion.php cuando publiques en hosting.
$host = 'TU_HOST_DB';
$user = 'TU_USUARIO_DB';
$password = 'TU_PASSWORD_DB';
$database = 'TU_BD';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
