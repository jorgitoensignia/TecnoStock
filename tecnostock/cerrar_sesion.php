<?php
session_start();
header('Cache-Control: no-store');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Método no permitido.');
}
$token = $_POST['csrf'] ?? '';
if (!is_string($token) || empty($_SESSION['csrf_logout']) || !hash_equals($_SESSION['csrf_logout'], $token)) {
    http_response_code(403);
    exit('Solicitud no válida.');
}
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();
header('Location: login.php', true, 303);
exit;
