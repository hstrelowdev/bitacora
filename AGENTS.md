# AGENTS.md — Bitácora de Solicitudes
Aplicación interna para registrar, asignar y dar seguimiento a solicitudes de trabajo,
con historial automático de cada cambio. Laravel 13 + PHP 8.3, vistas Blade, Bootstrap 5
por CDN y SQLite. No hay API ni build de frontend para la aplicación.

## Stack y estructura
- Backend Laravel 13 (PHP 8.3+); vistas Blade; Bootstrap 5 por CDN; SQLite como única base de datos.
- `routes/web.php` → `app/Http/Controllers` → `app/Models`; una carpeta de vistas por recurso en `resources/views`.
- Layout principal: `resources/views/layouts/app.blade.php`; componentes Blade en `resources/views/components`.
- Los assets reales son archivos planos en `public/css` y `public/js`, cargados con `asset()`.
- `resources/css`, `resources/js`, `vite.config.js` y Tailwind son scaffold; solo los usa la vista `welcome`, que no está enrutada. No ejecutes `npm run build` para cambios normales de UI.

## Convenciones
- Todo el texto de interfaz, validaciones y mensajes flash va en español.
- Nombres del dominio en español: tablas `usuarios`, `solicitudes`, `historial`; campos `nombre`, `rol`, `fecha_solicitud`, etc. `App\Models\User` usa `usuarios` y `nombre`, no `name`.
- Los modelos usan atributos de Laravel 13 (`#[Fillable([...])]`, `#[Hidden(...)]`, `#[ObservedBy(...)]`), no `$fillable` ni registro manual del observer.
- Los resources no tienen `show`; el de solicitudes usa el parámetro `{solicitud}`.
- Reutiliza las constantes `Solicitud::ESTADOS`, `Solicitud::PRIORIDADES` y `Solicitud::CAMPOS` en lugar de repetir valores.
- Los controladores validan inline, paginan de 10 y redirigen con `with('ok', ...)` o `with('error', ...)`.

## Datos
- SQLite en `database/database.sqlite` (ignorado por Git). Si no existe: `touch database/database.sqlite` y `php artisan migrate --seed`.
- El seeder crea `test@bitacora.test` / `admin1234` (admin) y seis rubros.
- No hay factories (`database/factories` no existe): en tests usa `User::create([...])`, no `User::factory()`.
- Relaciones: Rubro → Empresa → Empleo → Solicitud; Solicitud → Historial.
- `historial.usuario_id` es nullable (`nullOnDelete`); borrar una solicitud elimina su historial (`cascadeOnDelete`).
- Si cambias el esquema o la forma de los datos, crea una migración nueva; no edites migraciones ya ejecutadas.

## Historial automático (fácil equivocarse)
- `SolicitudObserver` registra el historial solo: una fila `creada` al crear y una fila por cada campo modificado al actualizar.
- Nunca insertes filas en `historial` desde controladores, vistas o seeders.
- El observer ignora `created_at`, `updated_at` y `fecha_cierre`.
- `fecha_cierre` se calcula en `SolicitudController`: se pone la fecha actual al pasar a `terminada` y se limpia en cualquier otro estado.
- El modelo se llama `Historial` y la tabla es `historial` (singular), no `historials`.

## Forma de trabajar
- Haz solo lo que se pide: no agregues funcionalidades, rutas ni dependencias por tu cuenta.
- Cambios pequeños y enfocados; sigue los patrones existentes y no reescribas lo que ya funciona.
- Mantén la compatibilidad con los datos y rutas actuales.
- Al terminar, resume qué cambiaste y cualquier decisión que deba revisar el usuario.

## Límites
- ✅ Siempre: textos en español, historial vía observer, SQLite, nombres de dominio en español.
- ⚠️ Pregunta antes: agregar dependencias, cambiar el esquema o los datos guardados, tocar las reglas de autenticación (hoy `solicitudes` está fuera del grupo `auth`), migrar el frontend a Vite/Tailwind.
- 🚫 Nunca: escribir historial a mano, agregar API/cola/servidor de base de datos, hacer que la app dependa de `npm run build`, commitear `.env` o `database/database.sqlite`.
- ✅ Siempre: actualizar `MEMORY.md` al terminar cada tarea. 

## Verificación
- `php artisan test` — suite con SQLite en memoria. Ojo: hay 1 fallo preexistente (`ExampleTest` espera 200 en `/`, pero `/` redirige a `/login` con 302); usa `actingAs()` en tests de feature.
- `vendor/bin/pint --dirty` — formato (preset Laravel, sin `pint.json`).
- Prueba manual: `php artisan serve` y entra con `test@bitacora.test` / `admin1234`.
- No hay CI, análisis estático ni tests JS. Para reiniciar datos: `php artisan migrate:fresh --seed` (borra todo).
