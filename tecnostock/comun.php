<?php
session_start();
header('Cache-Control: no-store');
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php'); exit;
}
require_once __DIR__ . '/conexion.php';
function escapar($texto) {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}
function icono($nombre) {
    $trazos = [
        'cubo' => '<path d="M12 2 3 7v10l9 5 9-5V7L12 2ZM3 7l9 5 9-5M12 12v10"/>',
        'inicio' => '<path d="m3 10 9-7 9 7v10H3V10ZM9 20v-7h6v7"/>',
        'categorias' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
        'movimientos' => '<path d="M3 7h17m-5-5 5 5-5 5M21 17H4m5-5-5 5 5 5"/>',
        'alertas' => '<path d="m12 3 10 18H2L12 3Zm0 6v5m0 3v1"/>',
        'salir' => '<path d="M10 4H4v16h6m4-13 5 5-5 5m-6-5h11"/>',
        'resumen' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M7 16v-4m5 4V7m5 9v-7"/>',
        'flecha' => '<path d="m6 9 6 6 6-6"/>'
    ];
    return '<svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">' . ($trazos[$nombre] ?? '') . '</svg>';
}

try {
    $consulta = $pdo->prepare('SELECT nombre, correo FROM usuarios WHERE id_usuario = :id AND estado = 1');
    $consulta->execute(['id' => $_SESSION['id_usuario']]);
    $usuario = $consulta->fetch();
} catch (PDOException $e) {
    error_log($e->getMessage()); http_response_code(503); exit('No fue posible verificar la sesión. Intenta nuevamente.');
}
if (!$usuario) { $_SESSION = []; session_destroy(); header('Location: login.php'); exit; }
foreach (['csrf_logout','csrf_inventario'] as $token) {
    if (empty($_SESSION[$token])) $_SESSION[$token] = bin2hex(random_bytes(32));
}
$inicial = preg_match('/^./u', $usuario['nombre'], $letra) ? $letra[0] : 'U';
$menu = ['inicio'=>'Inicio','productos'=>'Productos','categorias'=>'Categorías','movimientos'=>'Movimientos','alertas'=>'Alertas de stock'];
$iconos = ['inicio'=>'inicio','productos'=>'cubo','categorias'=>'categorias','movimientos'=>'movimientos','alertas'=>'alertas'];
$rutas = ['inicio'=>'panel.php','productos'=>'productos.php','categorias'=>'categorias.php','movimientos'=>'movimientos.php','alertas'=>'alertas.php'];
function entrada($array, $clave) { return is_string($array[$clave] ?? null) ? trim($array[$clave]) : ''; }
function entero($valor, $min = 0) { return filter_var($valor, FILTER_VALIDATE_INT, ['options'=>['min_range'=>$min,'max_range'=>2147483647]]); }
function longitud($valor) { return preg_match_all('/./us', $valor, $m); }
function csrf() { return '<input type="hidden" name="csrf" value="'.escapar($_SESSION['csrf_inventario']).'">'; }
function verificarCsrf() { if (!hash_equals($_SESSION['csrf_inventario'], entrada($_POST,'csrf'))) { http_response_code(403); exit('Solicitud no válida.'); } }
function ir($ruta, $mensaje) { $_SESSION['aviso'] = $mensaje; header('Location: '.$ruta, true, 303); exit; }
function aviso() { if (isset($_SESSION['aviso'])) { echo '<p class="estado-ok aviso" role="status">'.escapar($_SESSION['aviso']).'</p>'; unset($_SESSION['aviso']); } }
function errorVista($mensaje) { if ($mensaje !== '') echo '<p class="mensaje-error" role="alert">'.escapar($mensaje).'</p>'; }
function precio($valor) { return '$'.number_format((float)$valor, 2, ',', '.'); }
function registrarMovimiento($pdo, $id, $tipo, $cantidad, $obs) {
    $s=$pdo->prepare('INSERT INTO movimientos (tipo,cantidad,observacion,id_producto,id_usuario) VALUES (?,?,?,?,?)');
    $s->execute([$tipo,$cantidad,$obs,$id,$_SESSION['id_usuario']]);
}
