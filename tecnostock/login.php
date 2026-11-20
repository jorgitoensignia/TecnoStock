<?php
session_start();
require_once __DIR__ . '/conexion.php';
header('Cache-Control: no-store');

if (isset($_SESSION['id_usuario'])) {
    header('Location: panel.php');
    exit;
}

if (empty($_SESSION['csrf_login'])) {
    $_SESSION['csrf_login'] = bin2hex(random_bytes(32));
}

$correo = $_SESSION['correo_login'] ?? '';
$paso = $correo === '' ? 1 : 2;
$mensaje = '';

// El correo se conserva temporalmente en la sesión, no en la URL.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $token = $_POST['csrf'] ?? '';

    if (!is_string($token) || !hash_equals($_SESSION['csrf_login'], $token)) {
        $mensaje = 'La solicitud no es válida. Intenta nuevamente.';
    } elseif ($accion === 'volver') {
        unset($_SESSION['correo_login']);
        header('Location: login.php');
        exit;
    } elseif ($accion === 'siguiente') {
        $correo = is_string($_POST['correo'] ?? null) ? trim($_POST['correo']) : '';
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || strlen($correo) > 120) {
            $paso = 1;
            $mensaje = 'Ingresa un correo electrónico válido.';
        } else {
            // No se confirma si el correo existe hasta verificar la contraseña.
            $_SESSION['correo_login'] = $correo;
            header('Location: login.php');
            exit;
        }
    } elseif ($accion === 'ingresar' && $paso === 2) {
        $clave = is_string($_POST['clave'] ?? null) ? $_POST['clave'] : '';
        if ($clave === '') {
            $mensaje = 'Ingresa tu contraseña.';
        } else {
            try {
                $sql = 'SELECT id_usuario, nombre, clave FROM usuarios
                        WHERE correo = :correo AND estado = 1';
                $sentencia = $pdo->prepare($sql);
                $sentencia->execute([':correo' => $correo]);
                $usuario = $sentencia->fetch();

                if ($usuario && password_verify($clave, $usuario['clave'])) {
                    session_regenerate_id(true);
                    $_SESSION['id_usuario'] = $usuario['id_usuario'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    unset($_SESSION['correo_login'], $_SESSION['csrf_login']);
                    header('Location: panel.php');
                    exit;
                }
                $mensaje = 'Correo o contraseña incorrectos.';
            } catch (PDOException $error) {
                $mensaje = 'No fue posible iniciar sesión. Intenta nuevamente.';
            }
        }
    }
}

function escapar($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TecnoStock - Inicio de sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css?v=4">
</head>
<body class="pagina-login">
    <main class="contenedor-login">
        <section class="tarjeta-login" aria-labelledby="titulo-login">
            <div class="marca">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 2 21 7v10l-9 5-9-5V7l9-5Z M3 7l9 5 9-5 M12 12v10"/>
                </svg>
                <span>TecnoStock</span>
            </div>

            <?php if ($paso === 1): ?>
                <h1 id="titulo-login">Iniciar sesión</h1>
                <form method="post" action="login.php" class="formulario-login">
                    <input type="hidden" name="csrf" value="<?= escapar($_SESSION['csrf_login']) ?>">
                    <input type="hidden" name="accion" value="siguiente">
                    <label class="visually-hidden" for="correo">Correo electrónico</label>
                    <input class="form-control" type="email" id="correo" name="correo" placeholder="Correo electrónico" autocomplete="username" maxlength="120" value="<?= escapar($correo) ?>" required autofocus>
                    <?php if ($mensaje !== ''): ?>
                        <p class="mensaje-error" role="alert"><?= escapar($mensaje) ?></p>
                    <?php else: ?>
                        <p class="ayuda-login">Ingresa con tu cuenta de TecnoStock.</p>
                    <?php endif; ?>
                    <div class="acciones">
                        <button type="submit" class="btn boton-ingresar">Siguiente</button>
                    </div>
                </form>
            <?php else: ?>
                <form method="post" action="login.php" class="cuenta-login">
                    <input type="hidden" name="csrf" value="<?= escapar($_SESSION['csrf_login']) ?>">
                    <button type="submit" name="accion" value="volver" class="boton-volver" aria-label="Volver a ingresar el correo">&#8592;</button>
                    <span><?= escapar($correo) ?></span>
                </form>
                <h1 id="titulo-login">Escribir contraseña</h1>
                <form method="post" action="login.php" class="formulario-login">
                    <input type="hidden" name="csrf" value="<?= escapar($_SESSION['csrf_login']) ?>">
                    <input type="hidden" name="accion" value="ingresar">
                    <label for="clave" class="visually-hidden">Contraseña</label>
                    <div class="campo-clave">
                        <input type="password" class="form-control" id="clave" name="clave" autocomplete="current-password" placeholder="Contraseña" required autofocus>
                        <button type="button" id="verClave" class="ver-clave" aria-controls="clave" aria-pressed="false">Mostrar</button>
                    </div>
                    <?php if ($mensaje !== ''): ?>
                        <p class="mensaje-error" role="alert"><?= escapar($mensaje) ?></p>
                    <?php else: ?>
                        <p class="ayuda-login">Ingresa la contraseña de tu cuenta.</p>
                    <?php endif; ?>
                    <div class="acciones">
                        <button type="submit" class="btn boton-ingresar">Iniciar sesión</button>
                    </div>
                </form>
            <?php endif; ?>
        </section>
        <button type="button" class="aviso" id="abrirAcerca" aria-haspopup="dialog">
            <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v6 M12 7v1"/></svg>
            <span>Acerca de TecnoStock</span>
        </button>
    </main>
    <!-- Ventana informativa: no requiere iniciar sesión. -->
    <dialog id="acercaTecnoStock" class="ventana-acerca" aria-labelledby="titulo-acerca">
        <div class="marca">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" aria-hidden="true">
                <path d="M12 2 21 7v10l-9 5-9-5V7l9-5Z M3 7l9 5 9-5 M12 12v10"/>
            </svg>
            <span>TecnoStock</span>
        </div>
        <h2 id="titulo-acerca">Acerca de TecnoStock</h2>
        <p class="version-acerca">Versión 1.0 (en desarrollo)</p>
        <p>Sistema de gestión de inventario diseñado para centralizar la información de los productos tecnológicos y facilitar el control de existencias.</p>
        <p><strong>Funcionalidades previstas:</strong></p>
        <ul>
            <li>Registro, búsqueda y edición de productos.</li>
            <li>Registro de entradas y salidas de inventario.</li>
            <li>Actualización de stock y alertas de existencias bajas.</li>
        </ul>
        <p class="nota-acerca">Proyecto académico de Sistemas de Información · 2026</p>
        <form method="dialog" class="acciones">
            <button type="submit" class="btn boton-ingresar" autofocus>Cerrar</button>
        </form>
    </dialog>
    <footer class="pie-login">TecnoStock &copy; 2026</footer>
    <script>
        const acerca = document.getElementById('acercaTecnoStock');
        document.getElementById('abrirAcerca').addEventListener('click', () => {
            acerca.showModal();
        });

        const clave = document.getElementById('clave');
        const boton = document.getElementById('verClave');
        if (boton && clave) {
            boton.addEventListener('click', () => {
                const mostrar = clave.type === 'password';
                clave.type = mostrar ? 'text' : 'password';
                boton.textContent = mostrar ? 'Ocultar' : 'Mostrar';
                boton.setAttribute('aria-pressed', String(mostrar));
            });
        }
    </script>
</body>
</html>
