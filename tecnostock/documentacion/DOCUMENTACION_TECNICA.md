# Documentación técnica y funcional de TecnoStock

## 1. Problema y objetivo

TecnoStock plantea el caso de un negocio de accesorios tecnológicos que administraba los productos con planillas. Esto dificulta controlar existencias, evita tener un registro uniforme y permite errores de duplicación. El objetivo del proyecto es disponer de un sistema web con base de datos relacional para controlar productos, categorías, stock y movimientos.

## 2. Actores y alcance

- **Encargado de inventario / Administrador**: accede al sistema, administra productos, registra movimientos y consulta el panel y las alertas.
- El alcance de este prototipo **no incluye** compras, ventas con facturación, multiempresa ni administración de usuarios desde la interfaz. Las categorías se pueden consultar y filtrar; no hay una pantalla para crearlas o editarlas.

## 3. Requerimientos funcionales

| ID | Requerimiento | Implementación |
| --- | --- | --- |
| RF01 | Iniciar sesión | `login.php` |
| RF02 | Registrar productos | `producto_form.php` |
| RF03 | Listar productos | `productos.php` |
| RF04 | Buscar y filtrar productos | `productos.php` |
| RF05 | Editar productos | `producto_form.php` |
| RF06 | Desactivar productos sin eliminar su historial | `producto_desactivar.php` |
| RF07 | Registrar entradas de inventario | `movimiento_form.php` |
| RF08 | Registrar salidas | `movimiento_form.php` |
| RF09 | Actualizar stock junto al movimiento | `movimiento_form.php`, `producto_form.php` |
| RF10 | Detectar productos bajo el stock mínimo | `alertas.php`, `panel.php` |
| RF11 | Consultar categorías | `categorias.php` |
| RF12 | Consultar historial de entradas y salidas | `movimientos.php` |

## 4. Requerimientos no funcionales

| ID | Criterio | Evidencia en la implementación |
| --- | --- | --- |
| RNF01 | Interfaz responsiva | Reglas `@media` en `panel.css` y `estilos.css` |
| RNF02 | Validación de entradas | Formularios PHP, `inventario.js` |
| RNF03 | Conexión parametrizada | PDO con emulación de prepared statements desactivada |
| RNF04 | Almacenar hash de contraseña | Verificación con `password_verify()`; hash bcrypt en el SQL de prueba |
| RNF05 | Integridad referencial | Claves foráneas de productos y movimientos |
| RNF06 | Entorno local | XAMPP, Apache y MariaDB/MySQL |
| RNF07 | Manejo de sesiones | Verificación de sesión en `comun.php`, regeneración al iniciar sesión |

## 5. Modelo de datos

**categorias**: `id_categoria` (PK), `nombre` (único), `descripcion`, `estado`.

**productos**: `id_producto` (PK), `codigo` (único), `nombre`, `descripcion`, `precio`, `stock_actual`, `stock_minimo`, `estado`, `fecha_registro`, `id_categoria` (FK).

**usuarios**: `id_usuario` (PK), `nombre`, `correo` (único), `clave` (hash), `estado`.

**movimientos**: `id_movimiento` (PK), `fecha_hora`, `tipo` (`entrada` o `salida`), `cantidad`, `observacion`, `id_producto` (FK), `id_usuario` (FK).

Relaciones: una categoría tiene muchos productos; un producto puede tener muchos movimientos; un usuario puede registrar muchos movimientos. Las tres claves foráneas se definen en `tecnostock.sql`.

## 6. Reglas de negocio

1. El código de producto debe ser único.
2. Precio, stock actual y stock mínimo no pueden ser negativos.
3. La cantidad de cada movimiento debe ser un entero mayor que cero.
4. Una salida nunca puede dejar existencias negativas.
5. Registrar un movimiento actualiza existencias y guarda el historial en una misma transacción.
6. Un producto con historial se **desactiva** en lugar de eliminarse físicamente.
7. El stock inicial mayor a cero se registra como una entrada; un ajuste de stock durante edición también genera movimiento.
8. Se considera **stock bajo cuando `stock_actual < stock_minimo`**; igualdad no genera alerta.
9. Las acciones sensibles de formularios utilizan tokens CSRF.

## 7. Flujo básico del sistema

1. La persona ingresa el correo y luego la contraseña.
2. `login.php` valida la sesión y redirige a `panel.php`.
3. Desde el menú se administran productos, se consultan categorías y se registran movimientos.
4. El panel resume las existencias; el módulo de alertas lista los productos bajo mínimo.
5. Al cerrar sesión se destruye la sesión y se regresa al inicio.

## 8. Tecnologías y organización

- **Servidor:** PHP 8, PDO, Apache.
- **Datos:** MariaDB/MySQL, tablas normalizadas y claves foráneas.
- **Interfaz:** HTML5, CSS3, JavaScript, Bootstrap 5.3.3 desde CDN para las vistas que lo usan.
- **Ejecución local:** XAMPP en Windows.
- **Organización:** páginas PHP por funcionalidad, utilidades comunes y CSS compartido para mantener una estética consistente.

## 9. Alcance de la validación

Esta documentación se creó revisando los archivos entregados. No acredita por sí misma la ejecución del sistema en un equipo nuevo ni sustituye una rúbrica específica de la asignatura. Revisar la matriz de pruebas antes de entregar.
