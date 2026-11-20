<?php
require __DIR__ . "/comun.php";
$seccion="inicio"; $tituloPagina="Panel principal";
$resumen = null;
$productos = $categorias = $movimientos = $alertas = [];
$error = false;
try {
    $resumen = $pdo->query('SELECT
        (SELECT COUNT(*) FROM productos WHERE estado = 1) AS productos,
        (SELECT COUNT(*) FROM categorias WHERE estado = 1) AS categorias,
        (SELECT COUNT(*) FROM movimientos) AS movimientos,
        (SELECT COUNT(*) FROM productos WHERE estado = 1 AND stock_actual < stock_minimo) AS alertas')->fetch();
    $productos = $pdo->query('SELECT p.codigo, p.nombre, c.nombre AS categoria, p.precio, p.stock_actual, p.stock_minimo
        FROM productos p JOIN categorias c ON c.id_categoria = p.id_categoria
        WHERE p.estado = 1 ORDER BY p.fecha_registro DESC, p.id_producto DESC LIMIT 5')->fetchAll();
    $categorias = $pdo->query('SELECT c.nombre, COUNT(p.id_producto) AS productos
        FROM categorias c LEFT JOIN productos p ON p.id_categoria = c.id_categoria AND p.estado = 1
        WHERE c.estado = 1 GROUP BY c.id_categoria, c.nombre ORDER BY c.nombre')->fetchAll();
    $movimientos = $pdo->query('SELECT m.fecha_hora, m.tipo, m.cantidad, p.nombre AS producto
        FROM movimientos m JOIN productos p ON p.id_producto = m.id_producto
        ORDER BY m.fecha_hora DESC, m.id_movimiento DESC LIMIT 5')->fetchAll();
    $alertas = $pdo->query('SELECT codigo, nombre, stock_actual, stock_minimo FROM productos
        WHERE estado = 1 AND stock_actual < stock_minimo ORDER BY stock_actual, nombre LIMIT 5')->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $error = true;
}
require __DIR__ . "/cabecera.php";
?>
        <div class="encabezado">
            <div><h1>Panel principal</h1><p>Bienvenido, <?= escapar($usuario['nombre']) ?></p></div>
            <div class="accesos"><a href="productos.php"><?= icono('cubo') ?><span>Consultar productos<small>Inventario</small></span></a><a href="movimientos.php"><?= icono('movimientos') ?><span>Ver movimientos<small>Existencias</small></span></a></div>
        </div>
        <?php if ($error): ?>
            <p class="mensaje-error" role="alert">No fue posible consultar el inventario. Comprueba la conexión e intenta nuevamente.</p>
        <?php else: ?>
        <details class="tarjeta" open>
            <summary><?= icono('resumen') ?><span>Resumen de inventario<small>Estado general de los productos y existencias</small></span><?= icono('flecha') ?></summary>
            <div class="contenido indicadores">
                <?php foreach (['productos'=>'Productos activos','categorias'=>'Categorías activas','movimientos'=>'Movimientos registrados','alertas'=>'Productos con stock bajo'] as $clave => $etiqueta): ?>
                <div class="indicador"><span><?= escapar($etiqueta) ?></span><strong><?= escapar($resumen[$clave]) ?></strong><a href="<?= escapar($rutas[$clave]) ?>">Ver detalles</a></div>
                <?php endforeach; ?>
            </div>
        </details>
        <details class="tarjeta" id="productos" open>
            <summary><?= icono('cubo') ?><span>Productos recientes<small>Últimos cinco productos activos registrados</small></span><?= icono('flecha') ?></summary>
            <div class="contenido">
                <?php if (!$productos): ?><p class="vacio">No hay productos registrados.</p><?php else: ?>
                <div class="tabla-scroll"><table><thead><tr><th>Código</th><th>Producto</th><th>Categoría</th><th>Precio</th><th>Stock</th></tr></thead><tbody>
                <?php foreach ($productos as $p): ?><tr><td><?= escapar($p['codigo']) ?></td><td><?= escapar($p['nombre']) ?></td><td><?= escapar($p['categoria']) ?></td><td>$<?= number_format((float)$p['precio'], 2, ',', '.') ?></td><td><?= escapar($p['stock_actual']) ?></td></tr><?php endforeach; ?>
                </tbody></table></div><?php endif; ?>
            </div>
        </details>
        <details class="tarjeta" id="categorias" open>
            <summary><?= icono('categorias') ?><span>Categorías<small>Clasificación de los productos del inventario</small></span><?= icono('flecha') ?></summary>
            <div class="contenido categorias">
                <?php if (!$categorias): ?><p class="vacio">No hay categorías activas.</p><?php endif; ?>
                <?php foreach ($categorias as $c): ?><div class="categoria"><strong><?= escapar($c['nombre']) ?></strong><small><?= escapar($c['productos']) ?> productos activos</small></div><?php endforeach; ?>
            </div>
        </details>
        <details class="tarjeta" id="movimientos" open>
            <summary><?= icono('movimientos') ?><span>Movimientos de inventario<small>Últimas cinco entradas y salidas registradas</small></span><?= icono('flecha') ?></summary>
            <div class="contenido">
                <?php if (!$movimientos): ?><p class="vacio">No hay movimientos registrados.</p><?php else: ?>
                <div class="tabla-scroll"><table><thead><tr><th>Fecha y hora</th><th>Producto</th><th>Tipo</th><th>Cantidad</th></tr></thead><tbody>
                <?php foreach ($movimientos as $m): ?><tr><td><?= escapar($m['fecha_hora']) ?></td><td><?= escapar($m['producto']) ?></td><td><?= escapar(ucfirst($m['tipo'])) ?></td><td><?= escapar($m['cantidad']) ?></td></tr><?php endforeach; ?>
                </tbody></table></div><?php endif; ?>
            </div>
        </details>
        <details class="tarjeta" id="alertas" open>
            <summary><?= icono('alertas') ?><span>Alertas de stock<small>Productos activos con existencias inferiores al mínimo</small></span><?= icono('flecha') ?></summary>
            <div class="contenido">
                <?php if (!$alertas): ?><p class="estado-ok">No hay productos con stock bajo.</p><?php else: ?>
                <p class="estado-alerta"><?= escapar($resumen['alertas']) ?> productos requieren atención (se muestran hasta cinco).</p>
                <div class="tabla-scroll"><table><thead><tr><th>Código</th><th>Producto</th><th>Stock actual</th><th>Stock mínimo</th></tr></thead><tbody>
                <?php foreach ($alertas as $a): ?><tr><td><?= escapar($a['codigo']) ?></td><td><?= escapar($a['nombre']) ?></td><td><?= escapar($a['stock_actual']) ?></td><td><?= escapar($a['stock_minimo']) ?></td></tr><?php endforeach; ?>
                </tbody></table></div><?php endif; ?>
            </div>
        </details>
        <?php endif; ?>
<?php require __DIR__ . "/pie.php"; ?>
