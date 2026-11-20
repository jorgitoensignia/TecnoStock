<?php
require __DIR__.'/comun.php';
$seccion='alertas'; $tituloPagina='Alertas de stock'; $error=''; $filas=[];
try { $filas=$pdo->query('SELECT id_producto,codigo,nombre,stock_actual,stock_minimo FROM productos WHERE estado=1 AND stock_actual < stock_minimo ORDER BY stock_actual,nombre')->fetchAll(); }
catch(PDOException $e) { error_log($e->getMessage()); $error='No fue posible consultar las alertas.'; }
require __DIR__.'/cabecera.php'; ?>
<div class="encabezado"><div><h1>Alertas de stock</h1><p>Productos activos con existencias inferiores al mínimo definido.</p></div></div>
<?php errorVista($error); ?><section class="tarjeta"><div class="titulo-tarjeta"><?= icono('alertas') ?><div>Stock bajo<small>Información actualizada desde el inventario.</small></div></div><div class="contenido modulo">
<?php if(!$error): if(!$filas): ?><p class="estado-ok">No hay productos con stock bajo.</p><?php else: ?><p class="estado-alerta"><?= count($filas) ?> productos requieren atención.</p><div class="tabla-scroll"><table><thead><tr><th>Código</th><th>Producto</th><th>Stock actual</th><th>Mínimo</th><th>Faltante</th><th>Acción</th></tr></thead><tbody><?php foreach($filas as $r): ?><tr><td><?= escapar($r['codigo']) ?></td><td><?= escapar($r['nombre']) ?></td><td class="stock-bajo"><?= escapar($r['stock_actual']) ?></td><td><?= escapar($r['stock_minimo']) ?></td><td><?= (int)$r['stock_minimo']-(int)$r['stock_actual'] ?></td><td><a href="movimiento_form.php?id=<?= (int)$r['id_producto'] ?>">Registrar entrada</a></td></tr><?php endforeach; ?></tbody></table></div><?php endif; endif; ?></div></section><?php require __DIR__.'/pie.php'; ?>
