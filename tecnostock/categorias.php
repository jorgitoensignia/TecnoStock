<?php
require __DIR__.'/comun.php';
$seccion='categorias'; $tituloPagina='Categorías'; $error=''; $filas=[];
try { $filas=$pdo->query('SELECT c.id_categoria,c.nombre,c.descripcion,c.estado,COUNT(p.id_producto) AS productos FROM categorias c LEFT JOIN productos p ON p.id_categoria=c.id_categoria AND p.estado=1 GROUP BY c.id_categoria,c.nombre,c.descripcion,c.estado ORDER BY c.nombre')->fetchAll(); }
catch(PDOException $e) { error_log($e->getMessage()); $error='No fue posible consultar las categorías.'; }
require __DIR__.'/cabecera.php'; ?>
<div class="encabezado"><div><h1>Categorías</h1><p>Clasificación de los productos del inventario.</p></div></div>
<?php errorVista($error); ?><section class="tarjeta"><div class="titulo-tarjeta"><?= icono('categorias') ?><div>Listado de categorías<small>Consulta los productos activos de cada categoría.</small></div></div><div class="contenido modulo">
<?php if (!$error): ?><div class="tabla-scroll"><table><thead><tr><th>Nombre</th><th>Descripción</th><th>Productos activos</th><th>Estado</th><th>Acción</th></tr></thead><tbody><?php foreach($filas as $r): ?><tr><td><?= escapar($r['nombre']) ?></td><td><?= escapar($r['descripcion']) ?></td><td><?= escapar($r['productos']) ?></td><td><?= $r['estado']?'Activa':'Inactiva' ?></td><td><a href="productos.php?categoria=<?= (int)$r['id_categoria'] ?>">Ver productos</a></td></tr><?php endforeach; ?></tbody></table></div><?php if(!$filas): ?><p class="vacio">No hay categorías registradas.</p><?php endif; endif; ?></div></section><?php require __DIR__.'/pie.php'; ?>
