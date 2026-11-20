<?php
require __DIR__.'/comun.php';
$seccion='movimientos'; $tituloPagina='Registrar movimiento'; $error=''; $productos=[]; $id=entero(entrada($_GET,'id'),1); $tipo='entrada'; $cantidad=''; $obs='';
try {
    if($_SERVER['REQUEST_METHOD']==='POST') {
        verificarCsrf(); $id=entero(entrada($_POST,'id_producto'),1); $tipo=entrada($_POST,'tipo'); $cantidad=entrada($_POST,'cantidad'); $obs=entrada($_POST,'observacion'); $n=entero($cantidad,1);
        if($id===false || !in_array($tipo,['entrada','salida'],true) || $n===false || longitud($obs)>255) $error='Selecciona un producto, tipo válido y cantidad entera superior a cero. La observación admite hasta 255 caracteres.';
        else {
            $pdo->beginTransaction();
            $s=$pdo->prepare('SELECT stock_actual FROM productos WHERE id_producto=? AND estado=1 FOR UPDATE'); $s->execute([$id]); $p=$s->fetch();
            if(!$p) throw new DomainException('Selecciona un producto activo.');
            $nuevo=(int)$p['stock_actual']+($tipo==='entrada'?$n:-$n);
            if($nuevo<0) throw new DomainException('Stock insuficiente: la salida no puede superar las existencias disponibles.');
            if($nuevo>2147483647) throw new DomainException('La entrada supera el máximo permitido de existencias.');
            $s=$pdo->prepare('UPDATE productos SET stock_actual=? WHERE id_producto=?'); $s->execute([$nuevo,$id]);
            registrarMovimiento($pdo,$id,$tipo,$n,$obs); $pdo->commit(); ir('movimientos.php','Movimiento registrado. Stock actualizado correctamente.');
        }
    }
} catch(DomainException $e) { if($pdo->inTransaction()) $pdo->rollBack(); $error=$e->getMessage(); }
catch(PDOException $e) { if($pdo->inTransaction()) $pdo->rollBack(); error_log($e->getMessage()); $error='No fue posible registrar el movimiento.'; }
try { $productos=$pdo->query('SELECT id_producto,codigo,nombre,stock_actual FROM productos WHERE estado=1 ORDER BY nombre')->fetchAll(); } catch(PDOException $e) { error_log($e->getMessage()); $error='No fue posible consultar los productos.'; }
require __DIR__.'/cabecera.php'; ?>
<div class="encabezado"><div><h1>Registrar movimiento</h1><p>Actualiza las existencias mediante una entrada o salida.</p></div><a href="movimientos.php">Volver a movimientos</a></div>
<?php errorVista($error); ?><section class="tarjeta"><div class="titulo-tarjeta"><?= icono('movimientos') ?><div>Información del movimiento<small>Los campos marcados con * son obligatorios.</small></div></div><div class="contenido modulo">
<?php if(!$productos): ?><p class="vacio">Necesitas un producto activo para registrar movimientos.</p><a href="producto_form.php">Registrar producto</a><?php else: ?>
<form method="post" data-validar="movimiento" class="formulario-inventario"><?= csrf() ?><div class="campos"><div class="campo-completo"><label for="id_producto">Producto *</label><select class="form-select" id="id_producto" name="id_producto" required><option value="">Seleccionar</option><?php foreach($productos as $p): ?><option value="<?= (int)$p['id_producto'] ?>" data-stock="<?= (int)$p['stock_actual'] ?>" <?= $id===(int)$p['id_producto']?'selected':'' ?>><?= escapar($p['codigo'].' - '.$p['nombre'].' (Stock: '.$p['stock_actual'].')') ?></option><?php endforeach; ?></select></div>
<div><label for="tipo">Tipo *</label><select class="form-select" id="tipo" name="tipo" required><option value="entrada" <?= $tipo==='entrada'?'selected':'' ?>>Entrada</option><option value="salida" <?= $tipo==='salida'?'selected':'' ?>>Salida</option></select></div><div><label for="cantidad">Cantidad *</label><input class="form-control" type="number" min="1" max="2147483647" step="1" id="cantidad" name="cantidad" value="<?= escapar($cantidad) ?>" required></div>
<div class="campo-completo"><label for="observacion">Observación</label><textarea class="form-control" id="observacion" name="observacion" maxlength="255" rows="3"><?= escapar($obs) ?></textarea></div></div><p class="nota" id="stock-previsto" aria-live="polite"></p><p class="mensaje-error error-cliente" role="alert" hidden></p><div class="acciones-form"><button class="boton-azul" type="submit">Guardar movimiento</button><a href="movimientos.php">Cancelar</a></div></form><?php endif; ?></div></section><?php require __DIR__.'/pie.php'; ?>
