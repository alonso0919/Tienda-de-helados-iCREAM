<?php
require_once __DIR__ . '/config/facturama.php';

echo "<pre>";
echo "API BASE: " . FACTURAMA_API_BASE . "\n";
echo "USER: " . FACTURAMA_API_USER . "\n";
echo "RFC: " . FACTURAMA_ISSUER_RFC . "\n\n";

$result = facturama_request('GET', '/TaxEntity');

print_r($result);
echo "</pre>";