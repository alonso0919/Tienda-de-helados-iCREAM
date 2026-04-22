<?php
// utils/email_automation.php
require_once __DIR__ . '/../config/email.php';

/**
 * Enviar correo de confirmación de pago al cliente de una venta.
 * Best-effort: si falla, la app no se detiene.
 */
function send_payment_confirmation_email(mysqli $conn, int $id_venta): bool {
    $stmt = $conn->prepare("SELECT nombre_cliente, email_cliente, total, fecha_venta FROM ventas WHERE id_venta = ? LIMIT 1");
    $stmt->bind_param('i', $id_venta);
    $stmt->execute();
    $v = $stmt->get_result()->fetch_assoc();
    if (!$v) return false;

    $to = trim((string)($v['email_cliente'] ?? ''));
    if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) return false;

    $nombre = (string)($v['nombre_cliente'] ?? '');
    $total = (string)($v['total'] ?? '');
    $fecha = (string)($v['fecha_venta'] ?? '');

    $subject = "Pago realizado con éxito (Venta #{$id_venta})";

    $body = "Hola {$nombre},\n\n"
          . "Tu pago ha sido realizado con éxito.\n"
          . "Venta: #{$id_venta}\n"
          . "Fecha: {$fecha}\n"
          . "Total: $ {$total}\n\n"
          . "¡Gracias por tu compra!\n"
          . "EngineeringShop\n";

    // Headers UTF-8 + From
    $fromName = APP_EMAIL_FROM_NAME;
    $fromEmail = APP_EMAIL_FROM;

    // Codifica el nombre para UTF-8 en cabeceras
    $encodedFromName = mb_encode_mimeheader($fromName, 'UTF-8', 'B', "\r\n");
    $headers = [];
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: text/plain; charset=UTF-8";
    $headers[] = "From: {$encodedFromName} <{$fromEmail}>";

    if (defined('APP_EMAIL_BCC') && APP_EMAIL_BCC) {
        $headers[] = "Bcc: " . APP_EMAIL_BCC;
    }

    // Enviar (best-effort)
    return @mail($to, mb_encode_mimeheader($subject, 'UTF-8', 'B', "\r\n"), $body, implode("\r\n", $headers));
}
