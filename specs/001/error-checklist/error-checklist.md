# error-checklist — Verificación del flujo crítico

## Estado
Borrador — pendiente de aprobación.

## Objetivo
Registrar los errores detectados al ejecutar el checklist de
`.opencode/commands/probar-flujo.md` sobre el estado actual de Bitácora,
para priorizar su corrección sin alterar código ni datos.

## Alcance
- Análisis y documentación únicamente.
- Sin cambios de código, esquema ni datos.
- Verificación con `php artisan test` (SQLite en memoria) y peticiones HTTP GET sin sesión.
- No se ejecutó `migrate:fresh` ni ninguna operación destructiva.

## Contexto verificado
- Fecha: 2026-11-09.
- App: `http://localhost:8000`.
- Datos actuales: 1 usuario, 6 rubros, 12 empresas, 12 empleos,
  11 solicitudes y 15 filas de historial.
- `php artisan test`: 1 test pasa y 1 falla de forma preexistente (`ExampleTest`).

## Checklist de errores

### Críticos
- [ ] **C-01 — `/solicitudes` está fuera de `auth` y falla sin sesión.**
  - Evidencia: `routes/web.php:26-28` registra el resource fuera del grupo `auth`.
  - `GET /solicitudes` y `GET /solicitudes/create` responden `500` sin sesión.
  - Causa: `layouts/app.blade.php:18` renderiza `<x-sidebar />` y
    `sidebar.blade.php:16` usa `auth()->user()->nombre`.
  - Riesgo adicional: `DELETE` y `PUT/PATCH` quedan accesibles sin autenticación;
    `POST /solicitudes` falla en `SolicitudController.php:31` (`$request->user()->id`).
  - Decisión requerida: confirmar que las solicitudes deben ser privadas y mover
    el resource al grupo `auth`.

### Altos
- [ ] **A-01 — Los roles `admin` y `gestor` no se aplican.**
  - `rol` existe en `database/migrations/0001_01_01_000000_create_users_table.php:19`
    y en `app/Models/User.php:10`, pero ningún controlador, middleware o vista lo consulta.
  - `README.md:21` anuncia "Autenticación y roles de usuario".
  - Decisión requerida: definir permisos por rol o retirar la promesa del README.

- [ ] **A-02 — Faltan filtros y conteos por estado, fecha y responsable.**
  - `README.md:3` y `README.md:20` los anuncian.
  - `SolicitudController@index` (`app/Http/Controllers/SolicitudController.php:13-21`)
    solo ordena y pagina; no recibe filtros ni calcula conteos.
  - `resources/views/solicitudes/index.blade.php` no tiene formulario de filtros
    ni contadores.

### Medios
- [ ] **M-01 — Atributos `data-confirmar` mal formados y con mensaje incorrecto.**
  - `resources/views/rubros/index.blade.php:30-31`: markup inválido; el mensaje
    correcto queda fuera del atributo.
  - `resources/views/empresas/index.blade.php:26-27`: el valor efectivo dice
    "¿Eliminar este rubro?" al borrar una empresa.
  - `resources/views/empleos/index.blade.php:28-29`: el valor efectivo dice
    "¿Eliminar este rubro?" al borrar un empleo.
  - `public/js/confirmar.js:2` lee `dataset.confirmar`, así que el usuario ve
    el mensaje equivocado.

- [ ] **M-02 — La paginación usa estilos de Tailwind, no de Bootstrap 5.**
  - Las cuatro tablas llaman a `$paginador->links()`:
    `rubros/index.blade.php:46`, `empresas/index.blade.php:42`,
    `empleos/index.blade.php:44` y `solicitudes/index.blade.php:48`.
  - `app/Providers/AppServiceProvider.php:20-23` no configura el paginador, por lo que
    Laravel usa su vista por defecto `pagination::tailwind`
    (`AbstractPaginator::$defaultView`).
  - Esa vista genera clases `flex`, `text-sm`, `rounded-md`, `dark:...`, etc. que
    Bootstrap 5 no interpreta; el resultado se ve como texto suelto o desalineado.
  - Se nota en empresas (12), empleos (12) y solicitudes (11) porque superan los 10
    registros por página; rubros (6) no muestra paginación.
  - Corrección sugerida: llamar a `Paginator::useBootstrapFive()` en
    `AppServiceProvider::boot()` o publicar la vista `pagination::bootstrap-5`.

### Bajos / documentación
- [ ] **B-01 — El README crea usuarios con `name` en lugar de `nombre`.**
  - `README.md:170-176` usa `'name' => 'Admin'`; la columna es `nombre` (`NOT NULL`)
    y el modelo es fillable con `nombre`.
  - Seguir el ejemplo falla o ignora el campo.

- [ ] **B-02 — No hay tests de feature y el único test falla por un motivo preexistente.**
  - Solo existe `tests/Feature/ExampleTest.php`, que espera `200` en `/` y recibe
    `302` (redirección a `/login`).
  - No hay pruebas de autenticación, CRUD, bloqueo de borrado, historial ni `fecha_cierre`.

## Observaciones (no son errores confirmados)
- `fecha_cierre` se calcula automáticamente (`SolicitudController.php:81-88`) y no se
  muestra en el listado ni se edita en el formulario. Confirmar si es lo deseado.
- El historial se genera correctamente vía `SolicitudObserver`: fila `creada` al crear,
  una fila por campo modificado e ignora `created_at`, `updated_at` y `fecha_cierre`.

## Fuera de alcance
- Corregir los hallazgos.
- Cambiar el esquema, los datos o las reglas de autenticación.
- Agregar dependencias.

## Criterios de aceptación
- [ ] `specs/001/error-checklist/error-checklist.md` existe y está en español.
- [ ] Cada error tiene evidencia verificable (archivo:línea o respuesta HTTP).
- [ ] Los fallos preexistentes están separados de los nuevos.
- [ ] Las decisiones que afectan autenticación o alcance quedan marcadas para el usuario.
