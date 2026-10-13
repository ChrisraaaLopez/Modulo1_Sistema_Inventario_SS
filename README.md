# Sistema de Inventario Escolar

Laravel para control de artículos, revisión patrimonial, cuentas con roles y registro de vehículos escolares.

## Cambios incluidos en esta versión

- Administración de cuentas: crear, editar, asignar rol, asociar empleado, cambiar contraseña y desactivar sin borrar el historial. Solo Administrador puede entrar a esta sección.
- Registro de vehículos escolares: autobús (Toro), camionetas de transporte y otros; placas, VIN/serie, marca, modelo, año, capacidad, observaciones y estado.
- Alta rápida de marca, modelo y factura desde el formulario de nuevo artículo, sin cambiar de pantalla.
- Arreglo de la ruta de modelos por marca, con mensajes claros cuando la petición falla en lugar de dejar el selector en “Cargando…”.
- Formulario de preparación de revisión con instrucciones para personas que no conocen el sistema.
- Accesos protegidos por rol en el servidor; ocultar un enlace en el menú no sustituye la autorización de rutas.

## Instalación local con Laragon y MySQL

1. Haz una copia de seguridad de tu base MySQL antes de aplicar cambios.
2. Copia `.env.example` como `.env` y ajusta `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` según tu Laragon. No compartas el archivo `.env`.
3. Instala dependencias con `composer install`.
4. Genera una clave con `php artisan key:generate`.
5. Revisa primero `php artisan migrate:status`. Si tu base existente no tiene un historial de migraciones consistente, **no ejecutes todas las migraciones a ciegas**: crea/añade la tabla `vehiculos` usando la migración `2026_10_12_000001_create_vehiculos_table.php` y registra esa migración de forma controlada. En una instalación limpia, ejecuta `php artisan migrate`.
6. Ejecuta `php artisan storage:link` para imágenes y archivos.
7. Ejecuta `php artisan serve` y abre `http://127.0.0.1:8000`.

## Roles

- **Administrador:** administra catálogos, artículos, cuentas de acceso, vehículos y periodos.
- **Revisor:** realiza revisiones y consulta el histórico.
- **Consulta:** consulta el inventario y el histórico.

Crea las cuentas desde **Administración → Cuentas de acceso** una vez que exista al menos una cuenta Administrador activa. Las contraseñas nuevas deben tener mínimo 8 caracteres.

## Importante

- El ZIP no incluye `.env`, contraseñas ni la base de datos real.
- Los roles deben existir en `roles` con los nombres `Administrador`, `Revisor` y `Consulta`.
- Las tablas `usuarios`, `roles`, `empleados`, `marcas`, `modelos`, `tipos` y `facturas` deben conservar los nombres de columnas usados por los modelos.
- El formulario de artículo requiere categoría, tipo, ubicación y empleado responsable; completa primero esos catálogos.
