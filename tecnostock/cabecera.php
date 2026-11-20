<?php if (!isset($seccion, $tituloPagina, $usuario)) { http_response_code(403); exit; } ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TecnoStock - <?= escapar($tituloPagina) ?></title>
    <?php if ($seccion !== 'inicio'): ?><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><?php endif; ?>
    <link rel="stylesheet" href="panel.css?v=2">
</head>
<body>
<header class="barra">
    <a class="marca-panel" href="panel.php"><?= icono('cubo') ?> TecnoStock</a>
    <div class="cuenta-superior"><span><?= escapar($usuario['nombre']) ?></span><span class="avatar pequeno" aria-hidden="true"><?= escapar($inicial) ?></span></div>
</header>
<div class="estructura">
    <aside class="lateral">
        <div class="perfil">
            <span class="avatar" aria-hidden="true"><?= escapar($inicial) ?></span>
            <div><strong><?= escapar($usuario['nombre']) ?></strong><small><?= escapar($usuario['correo']) ?></small><span class="rol">Encargado de inventario</span></div>
        </div>
        <nav aria-label="Menú principal">
            <?php foreach ($menu as $id => $titulo): ?>
                <a href="<?= escapar($rutas[$id]) ?>" class="enlace-menu<?= $id === $seccion ? ' activo' : '' ?>"<?= $id === $seccion ? ' aria-current="page"' : '' ?>><?= icono($iconos[$id]) ?><span><?= escapar($titulo) ?></span></a>
            <?php endforeach; ?>
            <form method="post" action="cerrar_sesion.php" class="form-salir">
                <input type="hidden" name="csrf" value="<?= escapar($_SESSION['csrf_logout']) ?>">
                <button class="enlace-menu" type="submit"><?= icono('salir') ?><span>Cerrar sesión</span></button>
            </form>
        </nav>
    </aside>
    <main class="principal" id="inicio">
