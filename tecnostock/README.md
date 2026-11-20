# TecnoStock — Sistema web de inventario

Proyecto académico de gestión de inventario para accesorios tecnológicos. Está construido con **PHP**, **MariaDB/MySQL**, **PDO**, **HTML**, **CSS**, **JavaScript** y **Bootstrap**. Se ejecuta localmente con **XAMPP**.

## Funcionalidades implementadas

- Inicio de sesión en dos pasos (correo electrónico y contraseña), con verificación de hash de contraseña.
- Panel principal con indicadores de productos activos, categorías, movimientos y alertas.
- Registro, búsqueda, filtrado y edición de productos.
- Desactivación lógica de productos para conservar su historial.
- Consulta de categorías y de productos por categoría.
- Registro de entradas y salidas, con validación del stock y actualización transaccional.
- Historial de movimientos con producto, usuario y fecha.
- Alertas de stock inferior al mínimo configurado.
- Interfaz adaptable a pantallas móviles con tablas desplazables horizontalmente.

## Requisitos

- XAMPP (Apache, PHP 8.x y MariaDB/MySQL).
- Navegador web.
- Conexión a internet solo si se quiere cargar Bootstrap desde el CDN definido en las páginas.

## Instalación local en Windows

1. Copia **todo el contenido de esta carpeta** a `C:\xampp\htdocs\tecnostock\`.
2. Inicia **Apache** y **MySQL** desde el panel de XAMPP.
3. Abre `http://localhost/phpmyadmin`.
4. Crea una base de datos llamada **`tecnostock`** con cotejamiento `utf8mb4` (por ejemplo, `utf8mb4_unicode_ci`).
5. Selecciona esa base de datos y entra en **Importar**.
6. Selecciona **`tecnostock.sql`**, pulsa **Importar / Continuar** y confirma que no haya errores.
7. Revisa `conexion.php`: la configuración original utiliza `localhost`, usuario `root` y contraseña vacía, como suele ocurrir en una instalación local de XAMPP. Si tu instalación es diferente, ajusta esos valores *solo en tu copia local*.
8. Accede a `http://localhost/tecnostock/login.php`.

**Importante:** `tecnostock.sql` es el respaldo actualizado con registros de demostración; `base_datos.sql` es un respaldo **inicial** y no debe importarse después del SQL actualizado. El archivo SQL no incluye `CREATE DATABASE`, por lo que el paso 4 es necesario.

## Cuenta de demostración

El respaldo incorpora el correo de prueba `admin@tecnostock.cl` y **solo el hash** de su contraseña. La contraseña en texto plano no se incluye en este paquete. Usa la contraseña que configuraste al crear al administrador en tu entorno de pruebas. No reutilices credenciales reales ni publiques contraseñas activas.

## Archivos principales

| Archivo | Función |
| --- | --- |
| `login.php`, `cerrar_sesion.php` | Autenticación y cierre de sesión |
| `comun.php`, `conexion.php` | Sesión, utilidades y base de datos |
| `panel.php` | Resumen del inventario |
| `productos.php`, `producto_form.php`, `producto_desactivar.php` | Gestión de productos |
| `categorias.php` | Consulta de categorías |
| `movimientos.php`, `movimiento_form.php` | Consulta y registro de entradas/salidas |
| `alertas.php` | Productos con existencias bajo el mínimo |
| `cabecera.php`, `pie.php` | Estructura compartida de la interfaz |
| `panel.css`, `estilos.css`, `inventario.js` | Estilos e interacciones |
| `tecnostock.sql` | Respaldo con los datos de prueba |
| `base_datos.sql` | Versión inicial de la estructura SQL (conservar, no importar después del respaldo final) |

## Estructura de datos

Cuatro tablas: `usuarios`, `categorias`, `productos`, `movimientos`. Las relaciones son `productos.id_categoria → categorias.id_categoria`, `movimientos.id_producto → productos.id_producto` y `movimientos.id_usuario → usuarios.id_usuario`.

El respaldo incluido tiene 6 categorías, 6 productos (5 activos, 1 inactivo), 11 movimientos de inventario y 1 usuario. Contiene una alerta de stock bajo para el producto `TEC004` (stock 3, mínimo 5).

## Documentación adicional

- [`documentacion/DOCUMENTACION_TECNICA.md`](documentacion/DOCUMENTACION_TECNICA.md): alcance, requisitos, modelo y reglas de negocio.
- [`documentacion/MATRIZ_PRUEBAS.md`](documentacion/MATRIZ_PRUEBAS.md): casos y comprobaciones.
- [`documentacion/GUION_VIDEO.md`](documentacion/GUION_VIDEO.md): guion de demostración de hasta cinco minutos.
- [`documentacion/LISTA_ENTREGA.md`](documentacion/LISTA_ENTREGA.md): pasos finales y verificación.
- [`documentacion/REVISION_CODIGO.md`](documentacion/REVISION_CODIGO.md): alcance de la revisión y observaciones.

## Alcance y seguridad

El sistema está pensado para **demostración académica en un servidor local**. Antes de un despliegue público se necesitan medidas adicionales, como un usuario de base de datos con privilegios mínimos, protección de credenciales, HTTPS, limitación de intentos de acceso y copias de seguridad automatizadas. **No publiques información privada real en GitHub.**

**Revisión disponible:** todos los archivos PHP pasaron `php -l` (sintaxis). La ejecución integrada en Apache/MySQL no se ha probado desde este paquete; los resultados de las pruebas funcionales provienen de las comprobaciones reportadas durante el desarrollo.
