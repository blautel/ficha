## Registro de fichaje de empleados

Ejemplo básico de Laravel + Backpack para guardar registro de horas trabajadas por empleados.

- Cada usuario registrado puede iniciar y finalizar exclusivamente su jornada.
- Solo una jornada puede estar activa. No se permite iniciar una nueva jornada mientras no se haya finalizado la anterior.
- El administrador solo puede consultar las jornadas de otros usuarios, no modificarlas.

### Instalación

La instalación es muy sencilla, con pasos comunes, a través de `composer` y comandos de Laravel `php artisan`:

1. Clonar el repositorio y situarse en la raíz del proyecto.
2. Ejecutar `$ composer install`.
3. Modificar el fichero `.env` con la configuración de la base de datos.
4. Es posible que sea necesario generar la key de Laravel: `$ php artisan key:generate`.
5. Ejecutar las migraciones y cargar datos de prueba: `$ php artisan migrate --seed`

### Configuración necesaria

La aplicación utiliza el paquete ```backpack/permissionmanager``` para gestionar usuarios, roles y permisos. Es necesario que exista el permiso `gest-accesos` para habilitar el acceso a la gestión de usuarios-roles-permisos (tanto via menú lateral como con url). El permiso `gest-accesos` se crea con el seed durante la instalación.

La pantalla de login muestra los usuarios existentes. Una vez conectado como admin se puede modificar al gusto.
