<?php
require __DIR__.'/comun.php';
$seccion='productos'; $tituloPagina='Productos'; $error='';
$q=entrada($_GET,'q'); $cat=entero(entrada($_GET,'categoria'),1); $estado=entrada($_GET,'estado');
if (!in_array($estado,['1','0','todos'],true)) $estado='1';
$categorias=$productos=[];
try {
    $categorias=$pdo->query('SELECT id_categoria,nombre FROM categorias ORDER BY nombre')->fetchAll();
    $sql='SELECT p.*,c.nombre AS categoria FROM productos p JOIN categorias c ON c.id_categoria=p.id_categoria WHERE 1=1'; $params=[];
    if ($q!=='') { $sql.=' AND (p.codigo LIKE ? OR p.nombre LIKE ? OR c.nombre LIKE ?)'; $params=array_merge($params,array_fill(0,3,'%'.$q.'%')); }
    if ($cat!==false) { $sql.=' AND p.id_categoria=?'; $params[]=$cat; }
    if ($estado!=='todos') { $sql.=' AND p.estado=?'; $params[]=$estado; }
    $s=$pdo->prepare($sql.' ORDER BY p.nombre,p.id_producto'); $s->execute($params); $productos=$s->fetchAll();
} catch(PDOException $e) { error_log($e->getMessage()); $error='No fue posible consultar los productos.'; }
require __DIR__.'/cabecera.php'; ?>
<div class="encabezado"><div><h1>Productos</h1><p>Administra el catálogo de productos del inventario.</p></div><div><a class="boton-azul" href="producto_form.php">+ Nuevo producto</a></div></div>
<?php aviso(); errorVista($error); ?>
<section class="tarjeta"><div class="titulo-tarjeta"><?= icono('cubo') ?><div>Listado de productos<small>Busca por código, nombre o categoría.</small></div></div><div class="contenido modulo">
<form class="filtros" method="get" action="productos.php">
<div><label for="q">Buscar</label><input class="form-control" id="q" name="q" maxlength="100" value="<?= escapar($q) ?>" placeholder="Código, nombre o categoría"></div>
<div><label for="categoria">Categoría</label><select class="form-select" id="categoria" name="categoria"><option value="">Todas</option><?php foreach($categorias as $c): ?><option value="<?= escapar($c['id_categoria']) ?>" <?= $cat===(int)$c['id_categoria']?'selected':'' ?>><?= escapar($c['nombre']) ?></option><?php endforeach; ?></select></div>
<div><label for="estado">Estado</label><select class="form-select" id="estado" name="estado"><?php foreach(['1'=>'Activos','0'=>'Inactivos','todos'=>'Todos'] as $v=>$n): ?><option value="<?= $v ?>" <?= (string)$v===$estado?'selected':'' ?>><?= $n ?></option><?php endforeach; ?></select></div>
<div class="acciones-form"><button class="boton-azul" type="submit">Buscar</button><a href="productos.php">Limpiar</a></div></form>
<?php if (!$error): ?><p class="nota"><?= count($productos) ?> productos encontrados.</p>
<?php if (!$productos): ?><p class="vacio">No hay productos que coincidan con la búsqueda.</p><?php else: ?><div class="tabla-scroll"><table><thead><tr><th>Código</th><th>Producto</th><th>Categoría</th><th>Precio</th><th>Stock</th><th>Mínimo</th><th>Estado</th><th>Acciones</th></tr></thead><tbody>
<?php foreach($productos as $r): ?><tr><td><?= escapar($r['codigo']) ?></td><td><?= escapar($r['nombre']) ?></td><td><?= escapar($r['categoria']) ?></td><td><?= precio($r['precio']) ?></td><td class="<?= $r['estado'] && $r['stock_actual']<$r['stock_minimo']?'stock-bajo':'' ?>"><?= escapar($r['stock_actual']) ?><?= $r['estado'] && $r['stock_actual']<$r['stock_minimo']?' (Bajo)':'' ?></td><td><?= escapar($r['stock_minimo']) ?></td><td><?= $r['estado']?'Activo':'Inactivo' ?></td><td><?php if($r['estado']): ?><a href="producto_form.php?id=<?= (int)$r['id_producto'] ?>">Editar</a> <span class="separador">·</span> <a href="producto_desactivar.php?id=<?= (int)$r['id_producto'] ?>">Desactivar</a><?php else: ?><a class="boton-azul" href="producto_activar.php?id=<?= (int)$r['id_producto'] ?>">Activar</a><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; endif; ?>
</div></section><?php require __DIR__.'/pie.php'; ?>
