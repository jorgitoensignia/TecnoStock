<?php
require __DIR__.'/comun.php';
$seccion='productos'; $tituloPagina='Desactivar producto'; $error=''; $producto=null; $id=entero(entrada($_GET,'id'),1);
try {
    $s=$pdo->prepare('SELECT codigo,nombre FROM productos WHERE id_producto=? AND estado=1'); $s->execute([$id?:0]); $producto=$s->fetch();
    if (!$producto) { http_response_code(404); $error='El producto no existe o ya está inactivo.'; }
    elseif ($_SERVER['REQUEST_METHOD']==='POST') {
        verificarCsrf(); $s=$pdo->prepare('UPDATE productos SET estado=0 WHERE id_producto=? AND estado=1'); $s->execute([$id]);
        ir('productos.php',$s->rowCount()?'Producto desactivado correctamente.':'El producto ya estaba inactivo.');
    }
} catch(PDOException $e) { error_log($e->getMessage()); $error='No fue posible desactivar o consultar el producto.'; }
require __DIR__.'/cabecera.php'; ?>
<div class="encabezado"><div><h1>Desactivar producto</h1><p>Confirma el cambio de estado.</p></div><a href="productos.php">Volver a productos</a></div>
<?php errorVista($error); if($producto): ?><section class="tarjeta"><div class="titulo-tarjeta"><?= icono('alertas') ?><div>Confirmación</div></div><div class="contenido modulo"><p>¿Deseas desactivar <strong><?= escapar($producto['nombre']) ?></strong> (<?= escapar($producto['codigo']) ?>)?</p><p>El producto permanecerá en la base de datos junto con su historial. No se podrán registrar nuevos movimientos.</p><form method="post"><?= csrf() ?><div class="acciones-form"><button class="boton-azul" type="submit">Desactivar producto</button><a href="productos.php">Cancelar</a></div></form></div></section><?php endif; require __DIR__.'/pie.php'; ?>
