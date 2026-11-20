# Matriz de pruebas de TecnoStock

**Criterio de registro:** el usuario reportó resultados correctos para pruebas funcionales y diseño responsivo durante el desarrollo. En la preparación de este paquete se verificaron por separado la **sintaxis PHP** y la **consistencia básica del SQL**, sin ejecutar un servidor web ni una base de datos. La columna «Estado» distingue cada tipo de comprobación.

| ID | Caso de prueba | Procedimiento | Resultado esperado | Estado |
| --- | --- | --- | --- | --- |
| P01 | Inicio de sesión correcto | Ingresar correo válido y contraseña correcta | Accede al panel | Reportado como correcto en pruebas previas |
| P02 | Inicio de sesión incorrecto | Introducir contraseña errónea | Mensaje genérico y acceso denegado | Implementación revisada, repetición aconsejada |
| P03 | Registrar producto | Crear producto con código único, categoría y stock inicial | Aparece en listado; crea entrada inicial | Reportado como correcto |
| P04 | Duplicación de código | Reutilizar un código existente | No permite registrar duplicados | Validación implementada, repetición aconsejada |
| P05 | Buscar y filtrar | Buscar por código/nombre y cambiar categoría/estado | Resultados filtrados | Reportado como correcto |
| P06 | Editar producto | Modificar precio, mínimos y stock | Guarda cambios; registra ajuste si cambia stock | Reportado como correcto |
| P07 | Registrar entrada | Sumar unidades a un producto activo | Aumenta stock y aparece en historial | Reportado como correcto |
| P08 | Registrar salida | Registrar una salida dentro de existencias | Disminuye stock y aparece en historial | Reportado como correcto |
| P09 | Bloquear salida excesiva | Solicitar más unidades que las disponibles | Rechaza y conserva stock previo | Reportado como correcto |
| P10 | Alerta de stock | Dejar unidades por debajo del mínimo | Aparece aviso en el panel y en Alertas | Reportado como correcto |
| P11 | Igualdad con el mínimo | Dejar stock exactamente igual al mínimo | No se genera alerta | Reportado como correcto |
| P12 | Desactivar producto | Desactivar producto con historial | Desaparece de activos; persiste en inactivos/historial | Reportado como correcto |
| P13 | Cerrar sesión | Pulsar «Cerrar sesión» | Vuelve al login e impide acceder sin sesión | Reportado como correcto |
| P14 | Vista móvil | Usar DevTools a 393 × 852 px | Menú y tarjetas se adaptan; tablas permiten scroll | Reportado como correcto |
| P15 | Sintaxis PHP | Ejecutar `php -l` sobre los 14 `.php` | Sin errores de sintaxis | **Verificado automáticamente** |
| P16 | Datos y relaciones SQL | Revisar volcado `tecnostock.sql` | 4 tablas, 3 FK, 6 productos, 6 categorías, 11 movimientos, 1 usuario | **Verificado estáticamente** |

## Datos de referencia del respaldo

- Productos: 6 en total, 5 activos, 1 inactivo.
- Categorías: 6 activas.
- Movimientos: 11.
- Usuarios: 1 administrador de demostración.
- Alerta: `TEC004`, Cable HDMI 2 metros, stock actual **3**, stock mínimo **5**, faltante **2**.

## Recomendaciones para una revisión final

Si la rúbrica exige **evidencias visuales**, tomar capturas reales en el navegador: login, panel, productos y filtros, ingreso/edición de producto, historial, alertas, vista móvil y phpMyAdmin. Las capturas no se incluyen porque no fueron entregadas en el conjunto de archivos actual.

Registrar el entorno de la prueba (Windows, XAMPP, navegador) y fecha. No declarar «ejecutado» un caso que solo se deduce del código.
