# Dacota

Laravel 13 con autenticación (Breeze) y roles/permisos ([spatie/laravel-permission](https://spatie.be/docs/laravel-permission)).
Interfaz basada en **MaterialPro Bootstrap Lite** (Bootstrap 5 + Sass + jQuery).

## Credenciales

| Usuario  | Contraseña  | Rol    |
| -------- | ----------- | ------ |
| `admin`  | `12345678`  | admin  |
| `editor` | `12345678`  | editor |
| `demo`   | `12345678`  | user   |

El login acepta **usuario o correo** (`admin` o `admin@dacota.com`).

## Puesta en marcha

```sh
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

No hay paso de compilación de assets: el frontend usa los archivos ya compilados de la plantilla,
servidos desde `public/assets`.

## Frontend

Bootstrap 5 (vía MaterialPro) en lugar de Tailwind. Los assets se copiaron de
`material-pro-lite-master/` a `public/assets/`:

| Ruta                                | Contenido                              |
| ----------------------------------- | -------------------------------------- |
| `public/assets/css/styles.min.css`  | Tema completo (Bootstrap + MaterialPro) |
| `public/assets/css/app.css`         | Parches de la aplicación               |
| `public/assets/js/`                 | `app.min.js`, `sidebarmenu.js`         |
| `public/assets/libs/`               | jQuery, Bootstrap, SimpleBar, ApexCharts |
| `public/assets/images/`             | Logos, avatares, fondos                |

Notas sobre la plantilla:

- Los iconos son **Tabler Icons** (`.ti ti-*`), incluidos localmente. La plantilla original usaba
  `iconify-icon` desde un CDN; se sustituyó para no depender de la red.
- El CSS de la versión Lite no incluye reglas de colapso del sidebar en escritorio, ni para
  `.hide-menu`. Esas reglas están en `public/assets/css/app.css`.
- Se eliminaron Alpine.js y los componentes Blade que dependían de él (`modal`, `dropdown`,
  `nav-link`, `responsive-nav-link`). El menú lateral y los desplegables usan Bootstrap, y la
  eliminación de cuenta usa un modal de Bootstrap.

Estructura de las vistas:

- `resources/views/layouts/app.blade.php` — shell principal
- `resources/views/layouts/guest.blade.php` — shell de autenticación
- `resources/views/layouts/partials/` — `topstrip`, `sidebar`, `header`, `footer`


## Base de datos

MySQL en `127.0.0.1:3306`, base `dacota`, usuario `root` sin contraseña. Configurado en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dacota
DB_USERNAME=root
DB_PASSWORD=
```

## Roles incluidos

| Rol     | Permisos                                        |
| ------- | ----------------------------------------------- |
| `admin` | todos                                           |
| `editor`| `users.view`, `roles.view`                      |
| `user`  | ninguno                                         |

Permisos creados: `users.view|create|update|delete`, `roles.view|create|update|delete`.

## Rutas protegidas

Se usan los middleware `role` y `permission` (registrados en `bootstrap/app.php`, requeridos por spatie v8):

| Ruta               | Middleware          |
| ------------------ | ------------------- |
| `/dashboard`       | `auth`, `verified`  |
| `/admin/users`     | `role:admin\|editor`|
| `/admin/roles`     | `role:admin`        |
| `/admin/permissions` | `role:admin`      |

En las vistas se usa la directiva `@role`:

```blade
@role('admin')
    <a href="{{ route('admin.roles.index') }}">Roles</a>
@endrole
```

## Estructura relevante

- `app/Models/User.php` — usa el trait `HasRoles` y el scope `whereIdentifier`
- `app/Http/Controllers/Admin/` — `UserController`, `RoleController`, `PermissionController`
- `app/Http/Requests/Auth/LoginRequest.php` — login por usuario o correo con rate limiting
- `database/seeders/` — `RoleSeeder`, `AdminUserSeeder`, `DemoUserSeeder`
- `resources/views/admin/` — vistas del panel

## Tests

```sh
php artisan test
```

41 tests cubren login por usuario/correo, credenciales del admin sembrado, y los permisos de cada rol.

> Nota: los tests usan SQLite en memoria, no tocan la base `dacota`.
