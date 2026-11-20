<?php
require __DIR__.'/comun.php';
$seccion='productos'; $id=entero(entrada($_GET,'id'),1); $editar=isset($_GET['id']); $tituloPagina=$editar?'Editar producto':'Registrar producto'; $error=''; $listo=true;
$datos=['codigo'=>'','nombre'=>'','descripcion'=>'','precio'=>'','stock_actual'=>'0','stock_minimo'=>'0','id_categoria'=>'']; $categorias=[]; $original=null;
try {
    if ($editar) {
        $s=$pdo->prepare('SELECT * FROM productos WHERE id_producto=? AND estado=1'); $s->execute([$id?:0]); $original=$s->fetch();
        if (!$original) { http_response_code(404); $error='El producto no existe o está inactivo.'; $listo=false; } else $datos=$original;
    }
    $categorias=$pdo->query('SELECT id_categoria,nombre FROM categorias WHERE estado=1 ORDER BY nombre')->fetchAll();
    if (!$categorias) { $error='No hay categorías activas.'; $listo=false; }
    if ($listo && $_SERVER['REQUEST_METHOD']==='POST') {
        verificarCsrf(); foreach (['codigo','nombre','descripcion','precio','stock_actual','stock_minimo','id_categoria'] as $campo) $datos[$campo]=entrada($_POST,$campo);
        $stock=entero($datos['stock_actual']); $min=entero($datos['stock_minimo']); $cat=entero($datos['id_categoria'],1);
        if ($datos['codigo']==='' || longitud($datos['codigo'])>20 || $datos['nombre']==='' || longitud($datos['nombre'])>100 || longitud($datos['descripcion'])>255) $error='Revisa el código, nombre y descripción.';
        elseif (!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/D',$datos['precio'])) $error='El precio debe ser no negativo, con hasta ocho enteros y dos decimales.';
        elseif ($stock===false || $min===false || $cat===false) $error='Selecciona una categoría e ingresa cantidades enteras no negativas.';
        else {
            $pdo->beginTransaction();
            $s=$pdo->prepare('SELECT id_categoria FROM categorias WHERE id_categoria=? AND estado=1'); $s->execute([$cat]);
            if (!$s->fetch()) throw new DomainException('Selecciona una categoría activa.');
            $valores=[$datos['codigo'],$datos['nombre'],$datos['descripcion'],$datos['precio'],$stock,$min,$cat];
            if ($editar) {
                $s=$pdo->prepare('SELECT stock_actual FROM productos WHERE id_producto=? AND estado=1 FOR UPDATE'); $s->execute([$id]); $actual=$s->fetch();
                if (!$actual) throw new DomainException('El producto ya no está activo.');
                $anterior=entero(entrada($_POST,'stock_anterior'));
                if ($anterior===false || (int)$actual['stock_actual']!==$anterior) throw new DomainException('El stock cambió desde que abriste el formulario. Recarga la página y vuelve a intentarlo.');
                $s=$pdo->prepare('UPDATE productos SET codigo=?,nombre=?,descripcion=?,precio=?,stock_actual=?,stock_minimo=?,id_categoria=? WHERE id_producto=?'); $s->execute([...$valores,$id]);
                $delta=$stock-$anterior; if ($delta!==0) registrarMovimiento($pdo,$id,$delta>0?'entrada':'salida',abs($delta),'Ajuste de stock al editar producto');
            } else {
                $s=$pdo->prepare('INSERT INTO productos (codigo,nombre,descripcion,precio,stock_actual,stock_minimo,id_categoria) VALUES (?,?,?,?,?,?,?)'); $s->execute($valores); $id=(int)$pdo->lastInsertId();
                if ($stock>0) registrarMovimiento($pdo,$id,'entrada',$stock,'Stock inicial');
            }
            $pdo->commit(); ir('productos.php',$editar?'Producto actualizado correctamente.':'Producto registrado correctamente.');
        }
    }
} catch (DomainException $e) { if($pdo->inTransaction()) $pdo->rollBack(); $error=$e->getMessage(); }
catch (PDOException $e) { if($pdo->inTransaction()) $pdo->rollBack(); error_log($e->getMessage()); $error=($e->errorInfo[1]??0)==1062?'El código de producto ya existe.':'No fue posible guardar o consultar el producto.'; }
require __DIR__.'/cabecera.php'; ?>
<div class="encabezado"><div><h1><?= escapar($tituloPagina) ?></h1><p>Completa los datos del producto.</p></div><a href="productos.php">Volver a productos</a></div>
<?php errorVista($error); if($listo): ?>
<section class="tarjeta"><div class="titulo-tarjeta"><?= icono('cubo') ?><div>Información del producto<small>Los campos marcados con * son obligatorios.</small></div></div><div class="contenido modulo">
<form method="post" data-validar="producto" class="formulario-inventario"><?= csrf() ?><?php if($editar): ?><input type="hidden" name="stock_anterior" value="<?= escapar($original['stock_actual']??'') ?>"><?php endif; ?>
<div class="campos"><div><label for="codigo">Código *</label><input class="form-control" id="codigo" name="codigo" maxlength="20" required value="<?= escapar($datos['codigo']) ?>"></div>
<div><label for="nombre">Nombre *</label><input class="form-control" id="nombre" name="nombre" maxlength="100" required value="<?= escapar($datos['nombre']) ?>"></div>
<div><label for="id_categoria">Categoría *</label><select class="form-select" id="id_categoria" name="id_categoria" required><option value="">Seleccionar</option><?php foreach($categorias as $c): ?><option value="<?= (int)$c['id_categoria'] ?>" <?= (string)$datos['id_categoria']===(string)$c['id_categoria']?'selected':'' ?>><?= escapar($c['nombre']) ?></option><?php endforeach; ?></select></div>
<div><label for="precio">Precio ($) *</label><input class="form-control" type="number" min="0" max="99999999.99" step="0.01" id="precio" name="precio" required value="<?= escapar($datos['precio']) ?>"></div>
<div><label for="stock_actual">Stock actual *</label><input class="form-control" type="number" min="0" max="2147483647" step="1" id="stock_actual" name="stock_actual" required value="<?= escapar($datos['stock_actual']) ?>"></div>
<div><label for="stock_minimo">Stock mínimo *</label><input class="form-control" type="number" min="0" max="2147483647" step="1" id="stock_minimo" name="stock_minimo" required value="<?= escapar($datos['stock_minimo']) ?>"></div>
<div class="campo-completo"><label for="descripcion">Descripción</label><textarea class="form-control" id="descripcion" name="descripcion" maxlength="255" rows="3"><?= escapar($datos['descripcion']) ?></textarea></div></div>
<p class="nota">El stock <?= $editar?'modificado se registrará como un movimiento de ajuste.':'inicial mayor a cero se registrará como una entrada.' ?></p>
<p class="mensaje-error error-cliente" role="alert" hidden></p><div class="acciones-form"><button class="boton-azul" type="submit">Guardar producto</button><a href="productos.php">Cancelar</a></div></form></div></section>
<?php endif; require __DIR__.'/pie.php'; ?>
