## Registro de fichaje de empleados

Ejemplo básico de Laravel + Backpack para guardar registro de horas trabajadas por empleados.

### Instalación

La instalación es muy sencilla, con pasos comunes, a través de `composer` y comandos de Laravel `php artisan`:

1. Clonar el repositorio y situarse en la raíz del proyecto.
2. Ejecutar `$ composer install`.
3. Modificar el fichero `.env` con la configuración de la base de datos.
4. Ejecutar las migraciones y cargar datos de prueba: `$ php artisan migrate --seed`

### Configuración necesaria

La aplicación utiliza el paquete ```backpack/permissionmanager``` para gestionar usuarios, roles y permisos. Es necesario crear el permiso `gest-accesos` para habilitar el acceso a la gestión de usuarios-roles-permisos, tanto en el menú lateral como con la url directamente.

La pantalla de login muestra los usuarios existentes. Una vez conectado como admin se puede modificar al gusto.
