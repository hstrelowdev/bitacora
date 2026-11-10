## Memoria

### Estado actual
- `AGENTS.md` está en español y describe el proyecto real: Laravel 13, Blade, Bootstrap por CDN, SQLite e historial automático.
- El comando de OpenCode `feature` vive en `.opencode/commands/feature.md`.
- El comando `probar-flujo` vive en `.opencode/commands/probar-flujo.md` y estandariza la verificación del flujo crítico.
- `opencode.json` y `skills-lock.json` están en `.gitignore`; se versiona `opencode.example.json` sin credenciales.

### Decisiones importantes
- La carpeta `commands` se movió a `.opencode/commands/` porque OpenCode descubre los comandos de proyecto en `.opencode/commands/*.md`. Se eliminó un archivo vacío llamado `.opencode` que impedía crear el directorio.
- `MEMORY.MD` se renombró a `MEMORY.md` para coincidir con las referencias de `AGENTS.md` y del comando `feature`.
- El frontend real usa `public/css` y `public/js`; Vite/Tailwind solo los usa la vista `welcome`, que no está enrutada.
- Se creó `probar-flujo.md` para repetir la prueba del flujo sin reexplicar el checklist cada vez.
- Se corrigió el frontmatter de `feature.md` (faltaba el `---` de cierre) y se reemplazó `@MEMORY.md` por una instrucción explícita de lectura.
- Se ignoró `opencode.json` porque contiene una API key local y se creó `opencode.example.json` con `{env:CONTEXT7_API_KEY}`. También se ignoró `skills-lock.json`; `.agents/skills` y `docs/` siguen versionados.

### Errores a evitar
- `php artisan test` tiene 1 fallo preexistente: `ExampleTest` espera 200 en `/`, pero `/` redirige a `/login` (302). Usar `actingAs()` en tests de feature.
- No insertar filas en `historial` a mano: lo hace `SolicitudObserver`.
- En comandos guardados de OpenCode, `@archivo` no adjunta el archivo; hay que pedir explícitamente que se lea (por ejemplo, `lee MEMORY.md`).
- No commitear `opencode.json`; usar `opencode.example.json` y definir `CONTEXT7_API_KEY` en el entorno.
- `.agents/skills/local-dates` pertenece al Diario de Estudio, no a Bitácora; no aplicarlo aquí.
