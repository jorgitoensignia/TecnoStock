# Guion para video explicativo de TecnoStock

**Duración objetivo: 4 min 30 s a 5 min.** Mostrar la aplicación funcionando en el navegador y, brevemente, Visual Studio Code/phpMyAdmin. Este documento es un **guion**: no constituye un video grabado.

## 0:00–0:30 — Presentación

> «Hola, en este video presentaré TecnoStock, un sistema web de gestión de inventario desarrollado como proyecto académico. El objetivo es centralizar el registro de productos tecnológicos y controlar las existencias de manera sencilla».

Mostrar pantalla de inicio de sesión y explicar el acceso en dos pasos.

## 0:30–1:10 — Tecnología y modelo de datos

> «El sistema utiliza PHP con PDO, MariaDB o MySQL, HTML, CSS y JavaScript. La base de datos tiene cuatro tablas: usuarios, categorías, productos y movimientos. Las relaciones permiten conocer qué producto corresponde a cada categoría y quién realizó cada movimiento».

Mostrar brevemente las cuatro tablas de `tecnostock` en phpMyAdmin; volver al navegador.

## 1:10–2:00 — Panel y productos

> «Al iniciar sesión aparece un panel con los productos activos, categorías, movimientos registrados y alertas de stock bajo. Desde Productos se puede registrar, buscar, filtrar y editar un artículo. La desactivación es lógica para conservar la trazabilidad del inventario».

Mostrar panel, listado y filtro sin perder tiempo escribiendo datos extensos.

## 2:00–3:00 — Entradas y salidas

> «Cada entrada suma unidades y cada salida las descuenta. El sistema registra fecha, tipo de movimiento, cantidad y usuario responsable. Además, valida que una salida no supere las existencias, evitando stocks negativos».

Mostrar un movimiento con **un producto de prueba** y luego el historial. Evitar modificar datos que se necesiten mantener para la evaluación; si se hace, generar un nuevo respaldo SQL.

## 3:00–3:45 — Alertas y reglas de negocio

> «TecnoStock genera una alerta cuando el stock actual es menor al mínimo. Por ejemplo, el cable HDMI tiene tres unidades y su mínimo es cinco, por lo que aparece en el listado de alertas. El sistema también controla códigos únicos y valida datos antes de guardar».

Mostrar pantalla de alertas y luego listado de productos.

## 3:45–4:25 — Responsividad y seguridad

> «La interfaz se adapta a distintos tamaños de pantalla. Para las contraseñas se utiliza verificación de hash; los formularios usan tokens contra solicitudes no autorizadas, y las consultas de datos sensibles utilizan sentencias preparadas. El sistema está configurado para trabajar en un entorno local».

Mostrar vista móvil con DevTools y cierre de sesión.

## 4:25–4:50 — Cierre

> «En conclusión, TecnoStock permite registrar productos, controlar entradas y salidas y detectar problemas de stock en una sola aplicación. De esta forma se reduce el trabajo manual y se mantiene un historial de los cambios».

## Antes de grabar

1. Verificar Apache/MySQL y las cuentas de prueba.
2. Comprobar que los datos del panel coinciden con el SQL que se entregará.
3. Cerrar ventanas ajenas al proyecto y ocultar datos privados.
4. Grabar pantalla y audio con una herramienta local (OBS o la disponible en Windows).
5. Exportar video y revisar que se escuche, se vea y cumpla la duración indicada por la rúbrica.
