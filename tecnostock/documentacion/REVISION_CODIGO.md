# Resultados de revisión estática de TecnoStock

## Comprobaciones realizadas

- **20 archivos fuente/SQL recibidos**: 14 PHP, 2 SQL, 2 CSS, 1 JavaScript y 1 README original.
- Los **14 archivos PHP** se revisaron con `php -l`: **sin errores de sintaxis**.
- Se comprobó la existencia de **4 tablas** y **3 claves foráneas** en `tecnostock.sql`.
- El respaldo final contiene **6 categorías, 6 productos, 11 movimientos y 1 usuario**.
- La integridad aritmética de los datos principales de stock coincide con los movimientos: `TEC001` 25+10-7=28 y `TEC004` 3+7-5-2=3.
- Código y diseño PHP/CSS/JS recibidos **copiados sin modificaciones**.

## Observaciones útiles

1. `base_datos.sql` es una exportación **inicial**: solo incluye datos de categorías; **no** contiene los seis productos, los movimientos ni el usuario. Usar `tecnostock.sql` para una instalación que reproduzca las pruebas.
2. `tecnostock.sql` **no incluye** `CREATE DATABASE`. Hay que crear primero la base `tecnostock` en phpMyAdmin antes de importar.
3. La conexión usa `root` sin contraseña (`conexion.php`) porque el proyecto está configurado para XAMPP local. No se recomienda así en un servidor público.
4. El respaldo incluye un **hash de contraseña** del administrador de demostración. Aunque no está en texto plano, no se debe reutilizar ese usuario o contraseña en un entorno real.
5. `login.php` usa `password_verify` y regeneración de sesión; los formularios de inventario usan verificación CSRF y sentencias preparadas. No se observa en el código limitación de intentos de acceso: sería recomendable para despliegue público.
6. Varias páginas usan Bootstrap desde CDN. Sin internet, algunos estilos de esas páginas podrían variar.
7. No se aportó la **rúbrica oficial** ni un registro de ejecución en una instalación limpia. Por tanto, no se puede certificar cumplimiento completo de requisitos docentes ni funcionamiento extremo a extremo solo con el análisis estático.
8. No se recibieron los archivos de la carpeta `img` mostrada en algunas capturas previas. Los PHP/CSS/JS entregados no hacen referencia explícita a archivos de imagen locales; si la carpeta contiene recursos que se necesiten para la entrega, incluirla antes de publicar.

## Cambios en este paquete

Solo se añadieron documentación, README ampliado y `.gitignore`. No se editó ninguna página PHP, CSS, JS ni archivo SQL.
