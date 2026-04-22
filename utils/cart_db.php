<?php
// utils/cart_db.php
// Persistencia de carrito en BD con expiración.

// Duración de “apartado” (minutos)
const CART_TTL_MINUTES = 30;

function cart_cleanup_expired(mysqli $conn): void {
    $sql = "DELETE c, ci FROM carts c LEFT JOIN cart_items ci ON ci.cart_id = c.id_cart WHERE c.expires_at < NOW()";
    $conn->query($sql);
}

function cart_get_or_create(mysqli $conn, ?int $user_id, string $guest_session_id): int {
    cart_cleanup_expired($conn);

    if ($user_id) {
        $stmt = $conn->prepare("SELECT id_cart FROM carts WHERE user_id = ? AND status = 'active' ORDER BY updated_at DESC LIMIT 1");
        $stmt->bind_param('i', $user_id);
    } else {
        $stmt = $conn->prepare("SELECT id_cart FROM carts WHERE guest_session_id = ? AND status = 'active' ORDER BY updated_at DESC LIMIT 1");
        $stmt->bind_param('s', $guest_session_id);
    }
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) return (int)$row['id_cart'];

    // Crear
    $expires = (new DateTime('now'))
        ->add(new DateInterval('PT' . CART_TTL_MINUTES . 'M'))
        ->format('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO carts (user_id, guest_session_id, status, expires_at) VALUES (?, ?, 'active', ?)");
    $uid = $user_id ? $user_id : null;
    // Para bind_param, null requiere tipo 'i' y set null con variable
    if ($user_id) {
        $stmt->bind_param('iss', $user_id, $guest_session_id, $expires);
    } else {
        // user_id null
        $null = null;
        $stmt->bind_param('iss', $null, $guest_session_id, $expires);
    }
    $stmt->execute();
    return (int)$conn->insert_id;
}

function cart_touch(mysqli $conn, int $cart_id): void {
    $expires = (new DateTime('now'))
        ->add(new DateInterval('PT' . CART_TTL_MINUTES . 'M'))
        ->format('Y-m-d H:i:s');
    $stmt = $conn->prepare("UPDATE carts SET updated_at = NOW(), expires_at = ? WHERE id_cart = ?");
    $stmt->bind_param('si', $expires, $cart_id);
    $stmt->execute();
}

function cart_set_items(mysqli $conn, int $cart_id, array $items): void {
    // items: [{product_id, name, price, quantity, image}]
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->bind_param('i', $cart_id);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, name, unit_price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($items as $it) {
            $pid = (int)($it['product_id'] ?? 0);
            $name = (string)($it['name'] ?? '');
            $price = (float)($it['price'] ?? 0);
            $qty = (int)($it['quantity'] ?? 1);
            $img = (string)($it['image'] ?? '');
            if ($name === '' || $qty <= 0) continue;
            $stmt->bind_param('iisdis', $cart_id, $pid, $name, $price, $qty, $img);
            $stmt->execute();
        }

        cart_touch($conn, $cart_id);
        $conn->commit();
    } catch (Throwable $e) {
        $conn->rollback();
        throw $e;
    }
}

function cart_get_items(mysqli $conn, int $cart_id): array {
    cart_cleanup_expired($conn);
    $stmt = $conn->prepare("SELECT product_id, name, unit_price AS price, quantity, image FROM cart_items WHERE cart_id = ? ORDER BY id_item ASC");
    $stmt->bind_param('i', $cart_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $out = [];
    while ($row = $res->fetch_assoc()) {
        $row['product_id'] = (int)$row['product_id'];
        $row['price'] = (float)$row['price'];
        $row['quantity'] = (int)$row['quantity'];
        $out[] = $row;
    }
    return $out;
}

function cart_attach_guest_to_user(mysqli $conn, string $guest_session_id, int $user_id): void {
    // Si existe carrito activo de invitado, lo asigna al usuario.
    cart_cleanup_expired($conn);
    $stmt = $conn->prepare("SELECT id_cart FROM carts WHERE guest_session_id = ? AND status='active' ORDER BY updated_at DESC LIMIT 1");
    $stmt->bind_param('s', $guest_session_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) return;
    $cart_id = (int)$row['id_cart'];

    $stmt = $conn->prepare("UPDATE carts SET user_id = ?, guest_session_id = NULL, updated_at = NOW() WHERE id_cart = ?");
    $stmt->bind_param('ii', $user_id, $cart_id);
    $stmt->execute();
}
