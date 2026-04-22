<?php
// Sandbox config for Facturama API Web.
// Fill these values with your sandbox credentials and fiscal profile data.

if (!defined('FACTURAMA_MODE')) define('FACTURAMA_MODE', 'sandbox');
if (!defined('FACTURAMA_API_BASE')) define('FACTURAMA_API_BASE', FACTURAMA_MODE === 'production' ? 'https://api.facturama.mx' : 'https://apisandbox.facturama.mx');
if (!defined('FACTURAMA_API_USER')) define('FACTURAMA_API_USER', 'Escuela09');
if (!defined('FACTURAMA_API_PASSWORD')) define('FACTURAMA_API_PASSWORD', 'alonso123');

if (!defined('FACTURAMA_ISSUER_RFC')) define('FACTURAMA_ISSUER_RFC', 'EKU9003173C9');
if (!defined('FACTURAMA_EXPEDITION_PLACE')) define('FACTURAMA_EXPEDITION_PLACE', '34167');
if (!defined('FACTURAMA_DEFAULT_SERIE')) define('FACTURAMA_DEFAULT_SERIE', 'ICE1');

if (!defined('FACTURAMA_DEFAULT_CFDI_NAME_ID')) define('FACTURAMA_DEFAULT_CFDI_NAME_ID', '1');

// Business rules for your store.
if (!defined('FACTURAMA_ENABLE_SANDBOX_ONLY')) define('FACTURAMA_ENABLE_SANDBOX_ONLY', true);
if (!defined('FACTURAMA_DEFAULT_PRODUCT_CODE')) define('FACTURAMA_DEFAULT_PRODUCT_CODE', '10111302'); // Ice cream / food-like generic for tests
if (!defined('FACTURAMA_DEFAULT_UNIT_CODE')) define('FACTURAMA_DEFAULT_UNIT_CODE', 'H87');
if (!defined('FACTURAMA_DEFAULT_UNIT')) define('FACTURAMA_DEFAULT_UNIT', 'Pieza');
if (!defined('FACTURAMA_DEFAULT_TAX_RATE')) define('FACTURAMA_DEFAULT_TAX_RATE', 0.16);
if (!defined('FACTURAMA_DEFAULT_PAYMENT_METHOD')) define('FACTURAMA_DEFAULT_PAYMENT_METHOD', 'PUE');
if (!defined('FACTURAMA_DEFAULT_EXPORTATION')) define('FACTURAMA_DEFAULT_EXPORTATION', '01');

function facturama_is_configured(): bool {
    return !empty(FACTURAMA_API_USER)
        && !empty(FACTURAMA_API_PASSWORD)
        && !empty(FACTURAMA_ISSUER_RFC);
}

function facturama_auth_header(): string {
    return 'Authorization: Basic ' . base64_encode(FACTURAMA_API_USER . ':' . FACTURAMA_API_PASSWORD);
}

function facturama_request(string $method, string $path, ?array $payload = null): array {
    $url = rtrim(FACTURAMA_API_BASE, '/') . '/' . ltrim($path, '/');
    $ch = curl_init($url);
    $headers = [
        'Accept: application/json',
        'Content-Type: application/json; charset=utf-8',
        facturama_auth_header(),
    ];
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => strtoupper($method),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 45,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_CAINFO => __DIR__ . '/cacert.pem',
    ]);
    if ($payload !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_UNICODE));
    }
    $resp = curl_exec($ch);
    $http = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    if ($resp === false) {
        return ['ok' => false, 'http' => 0, 'error' => 'Error cURL', 'detail' => $err];
    }

    $data = json_decode($resp, true);
    if ($http < 200 || $http >= 300) {
        return ['ok' => false, 'http' => $http, 'error' => 'Facturama error', 'detail' => $data ?: $resp];
    }

    return ['ok' => true, 'http' => $http, 'data' => $data];
}

function facturama_normalize_name(string $name): string {
    $name = mb_strtoupper(trim($name), 'UTF-8');
    $name = preg_replace('/\b(SA DE CV|S\.A\. DE C\.V\.|S DE RL DE CV|S\. DE R\.L\. DE C\.V\.|SC|S\.C\.|AC|A\.C\.)\b/u', '', $name);
    $name = preg_replace('/\s+/', ' ', trim((string)$name));
    return $name;
}

function facturama_payment_form_from_sale(array $venta): string {
    $status = strtolower((string)($venta['payment_status'] ?? ''));
    if (in_array($status, ['paid', 'created'], true)) {
        return '04'; // Tarjeta para la mayoría de pruebas Hosted Checkout
    }
    return '99'; // Por definir
}

function facturama_receiver_payload(array $fiscalData): array {
    return [
        'Rfc' => strtoupper(trim((string)$fiscalData['rfc'])),
        'Name' => facturama_normalize_name((string)$fiscalData['razon_social']),
        'CfdiUse' => (string)$fiscalData['cfdi_use'],
        'FiscalRegime' => (string)$fiscalData['fiscal_regime'],
        'TaxZipCode' => preg_replace('/\D+/', '', (string)$fiscalData['tax_zip_code']),
    ];
}

function facturama_item_from_sale_row(array $row): array {
    $qty = max(1, (int)($row['cantidad'] ?? 1));
    $total = round((float)($row['subtotal'] ?? 0), 2);
    $taxRate = FACTURAMA_DEFAULT_TAX_RATE;
    $subtotal = round($total / (1 + $taxRate), 2);
    $tax = round($total - $subtotal, 2);
    $unitPrice = round($subtotal / $qty, 2);

    return [
        'Quantity' => (string)$qty,
        'ProductCode' => (string)($row['sat_product_code'] ?? FACTURAMA_DEFAULT_PRODUCT_CODE),
        'UnitCode' => (string)($row['sat_unit_code'] ?? FACTURAMA_DEFAULT_UNIT_CODE),
        'Unit' => (string)($row['sat_unit'] ?? FACTURAMA_DEFAULT_UNIT),
        'Description' => (string)($row['nombre_producto'] ?? 'Producto'),
        'IdentificationNumber' => (string)($row['id_producto'] ?? ''),
        'UnitPrice' => number_format($unitPrice, 2, '.', ''),
        'Subtotal' => number_format($subtotal, 2, '.', ''),
        'TaxObject' => '02',
        'Taxes' => [[
            'Name' => 'IVA',
            'Rate' => number_format($taxRate, 2, '.', ''),
            'Total' => number_format($tax, 2, '.', ''),
            'Base' => number_format($subtotal, 2, '.', ''),
            'IsRetention' => 'false',
            'IsFederalTax' => 'true',
        ]],
        'Total' => number_format($total, 2, '.', ''),
    ];
}
