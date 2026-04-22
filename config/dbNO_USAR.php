<?php
header("Content-Type: application/json; charset=UTF-8");

function json_response($data, int $status = 200): void {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
function gt_ejson_body():array{
    $raw=file_get_contents("php://input");
    if(!$raw) return[];
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded :[];

}
function pdo(): PDO {
     //datos de tu bd
    $host = "127.0.0.1"; // MySQL host
    $port = 3306; // Puerto MySQL por defecto en XAMPP
    $db   = "engineeringstore";
    $user = "root";
    $pass = "";
    $charset = "utf8mb4";
    
    $dns = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

return new PDO($dns, $user, $pass, $options);

}