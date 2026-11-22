<?php
require __DIR__.'/comun.php';
$seccion='productos';
$tituloPagina='Activar producto';
$error='';
$producto=null;
$id=entero(entrada($_GET,'id'),1);
try {
    $s=$pdo->prepare('SELECT codigo,nombre FROM productos WHERE id_producto=? AND estado=0');
    $s->execute([$id?:0]);
    $producto=$s->fetch();
    if (!$producto) {
        http_response_code(404);
        $error='El producto no existe o ya está activo.';
    } elseif ($_SERVER['REQUEST_METHOD']==='POST') {
        verificarCsrf();
        $s=$pdo->prepare('UPDATE productos SET estado=1 WHERE id_producto=? AND estado=0');
        $s->execute([$id]);
        ir('productos.php', $s->rowCount() ? 'Producto activado correctamente.' : 'El producto ya estaba activo.');
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error='No fue posible activar o consultar el producto.';
}
require __DIR__.'/cabecera.php'; ?>
<div class="encabezado"><div><h1>Activar producto</h1><p>Confirma el cambio de estado.</p></div><a href="productos.php">Volver a productos</a></div>
<?php errorVista($error); if ($producto): ?>
<section class="tarjeta"><div class="titulo-tarjeta"><?= icono('cubo') ?><div>Confirmación</div></div><div class="contenido modulo">
<p>¿Deseas activar <strong><?= escapar($producto['nombre']) ?></strong> (<?= escapar($producto['codigo']) ?>)?</p>
<p>El producto volverá a estar disponible para editarlo y registrar movimientos. Se conservarán su stock y su historial anteriores.</p>
<form method="post"><?= csrf() ?><div class="acciones-form"><button class="boton-azul" type="submit">Activar producto</button><a href="productos.php">Cancelar</a></div></form>
</div></section><?php endif; require __DIR__.'/pie.php'; ?>
