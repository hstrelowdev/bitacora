---
description: Prueba el flujo crítico de la Bitácora y reporta resultados
agent: build
---

Prueba el flujo del sistema. Usa `$ARGUMENTS` para limitar el alcance:
`automatizado`, `manual` o `completo` (por defecto: `completo`).

Antes de empezar:
- Lee `AGENTS.md` y `MEMORY.md`.
- App: http://localhost:8000, SQLite en `database/database.sqlite`.
- Usuario de prueba: el creado por `DatabaseSeeder` (`test@bitacora.test`).
- `php artisan test` tiene 1 fallo preexistente (`ExampleTest` por el redirect a `/login`); no lo cuentes como regresión nueva.
- Si hay herramientas de navegador disponibles, úsalas para la parte manual; si no, usa `curl` y los tests.

Reglas:
- No ejecutes `migrate:fresh` sobre la BD actual.
- Para tests automatizados usa SQLite en memoria (`phpunit.xml`).
- Para pruebas manuales, crea registros marcados como prueba y bórralos al final.
- No modifiques código de producción sin aprobación; primero reporta.

Checklist:
1. Autenticación: login correcto/incorrecto, logout, ruta protegida sin sesión.
2. Rubros: crear, editar, activar/desactivar, bloqueo de borrado con dependencias.
3. Empresas: crear/editar, validación de rubro, bloqueo de borrado con empleos.
4. Empleos: crear/editar, validación de empresa/rubro, bloqueo de borrado con solicitudes.
5. Solicitudes: crear, editar, listar, borrar.
6. Historial: fila `creada` al crear; una fila por campo modificado; ignora `fecha_cierre`; `fecha_cierre` se setea al terminar y se limpia al reabrir.
7. Auth: verifica si `/solicitudes` debe ser público (hoy está fuera del grupo `auth`).
8. Filtros y conteos por estado, fecha y responsable.

Al terminar, entrega una tabla con: caso, resultado (OK/FALLO), evidencia y archivo/línea si aplica. Separa fallos preexistentes de regresiones nuevas.
