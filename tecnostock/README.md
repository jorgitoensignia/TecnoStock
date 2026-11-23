# Sistema de Inventario TecnoStock

**Autor:** Jorge Ensignia  
**Sección:** 301

## 1. Descripción del problema

TecnoStock es un emprendimiento dedicado a la venta de accesorios tecnológicos. Actualmente utiliza planillas para administrar su inventario, lo que genera códigos duplicados, errores en las cantidades y dificultades para conocer el stock real de los productos.

## 2. Objetivo general

Desarrollar una aplicación web que permita gestionar productos y movimientos de inventario utilizando una base de datos relacional.

## 3. Actor principal

Encargado de inventario: responsable de administrar productos, categorías y movimientos de existencias.

## 4. Requerimientos funcionales

- RF01: Iniciar sesión.
- RF02: Registrar productos.
- RF03: Listar productos.
- RF04: Buscar productos por nombre, código o categoría.
- RF05: Editar productos.
- RF06: Desactivar productos.
- RF07: Registrar entradas de inventario.
- RF08: Registrar salidas de inventario.
- RF09: Actualizar automáticamente el stock.
- RF10: Mostrar alertas de stock bajo.

## 5. Requerimientos no funcionales

- RNF01: Interfaz clara y responsiva.
- RNF02: Validaciones en cliente y servidor.
- RNF03: Conexión mediante PDO.
- RNF04: Almacenamiento seguro de contraseñas.
- RNF05: Integridad de la base de datos.
- RNF06: Funcionamiento en un servidor local.

## 6. Reglas de negocio

- RN01: Los códigos de productos deben ser únicos.
- RN02: Los precios, stocks y cantidades no pueden ser negativos.
- RN03: Cada movimiento debe registrar fecha, tipo, cantidad, producto y usuario responsable.
- RN04: Las salidas no pueden generar stock negativo.
- RN05: Los productos con movimientos deben desactivarse en lugar de eliminarse.
- RN06: El stock debe actualizarse automáticamente después de cada movimiento válido.

## 7. Tecnologías utilizadas

- HTML y CSS
- Bootstrap
- JavaScript
- PHP (PDO)
- MySQL
- XAMPP

## Cuenta de demostración

- **Correo:** `admin@tecnostock.cl`
- **Contraseña:** `Tecno1234!`
