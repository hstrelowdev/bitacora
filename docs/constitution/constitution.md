# Constitución del proyecto — Bitácora

Este documento establece los principios, restricciones y reglas fundamentales del proyecto **Bitácora**.

Toda especificación (`spec`), planificación (`plan`), tarea (`task`) e implementación debe respetar esta constitución y las convenciones técnicas definidas en `AGENTS.md`.

Ningún agente puede ignorar estos principios ni tomar decisiones que los contradigan sin autorización explícita del usuario.

## 1. Simplicidad y arquitectura

El proyecto debe mantener una arquitectura simple, comprensible y fácil de mantener.

- Utilizar exclusivamente las tecnologías y herramientas definidas en `AGENTS.md`.
- No incorporar frameworks, librerías, dependencias, servicios externos ni infraestructura adicional sin autorización explícita.
- Priorizar las funcionalidades nativas de Laravel y PHP antes de introducir soluciones adicionales.
- Reutilizar los componentes, modelos, métodos y patrones existentes cuando corresponda.
- Evitar abstracciones, capas arquitectónicas y complejidad innecesaria.
- No reescribir código funcional sin una justificación técnica.

Toda decisión arquitectónica debe responder a una necesidad real del proyecto.

## 2. La especificación es la fuente de verdad

La especificación (`spec`) activa es la única fuente de verdad para determinar el comportamiento esperado de cada funcionalidad.

- No implementar funcionalidades que no estén contempladas en la especificación activa.
- No asumir requisitos, comportamientos ni reglas de negocio que no estén documentados.
- No ampliar el alcance de una tarea por iniciativa propia.
- Si existe una ambigüedad, contradicción o falta de información, el agente debe detenerse y consultar al usuario antes de continuar.
- Cualquier modificación de los requisitos debe reflejarse primero en la especificación correspondiente.
- La implementación debe cumplir tanto la especificación activa como las restricciones de esta constitución.

Si una especificación contradice esta constitución, prevalece la constitución y se debe solicitar una aclaración.

## 3. Coherencia de las reglas de negocio

Toda funcionalidad debe tener sentido desde el punto de vista funcional y responder a las necesidades reales del sistema.

El agente debe analizar y verificar la coherencia de:

- **Inputs:** los campos deben solicitar información pertinente y aceptar datos válidos según su propósito.
- **Formularios:** los campos, validaciones y acciones deben respetar las reglas de negocio.
- **Tablas:** las columnas, relaciones, registros y acciones disponibles deben representar correctamente la información.
- **Datos mostrados:** los valores, estados, fechas y resultados deben ser correctos y coherentes.
- **Interacciones:** cada acción debe tener un propósito claro y producir el resultado esperado.
- **Estados y transiciones:** los cambios de estado deben respetar las condiciones y restricciones del negocio.
- **Relaciones:** las asociaciones entre entidades deben preservar la integridad y coherencia de los datos.

No basta con que una funcionalidad funcione técnicamente: también debe ser correcta desde el punto de vista del negocio y comprensible para el usuario.

Si se detecta una inconsistencia:
- Documentar el problema identificado.
- No inventar una regla de negocio para resolverlo.
- Consultar al usuario cuando la solución implique modificar un comportamiento funcional.

## 4. Separación de responsabilidades

La lógica de negocio debe mantenerse separada de la presentación y de las responsabilidades propias de cada componente.

- Los controladores deben gestionar las solicitudes HTTP, validar los datos y coordinar las operaciones correspondientes.
- Los modelos deben representar las entidades y sus relaciones.
- Las vistas deben encargarse de presentar la información y gestionar la interacción del usuario.
- La lógica de negocio debe ubicarse donde corresponda según las responsabilidades existentes del proyecto.
- Evitar duplicar reglas de negocio en controladores y vistas.
- Los cálculos y operaciones que puedan mantenerse independientes de la interfaz deben implementarse de forma desacoplada.
- Las fechas utilizadas en cálculos deben poder controlarse y probarse sin depender innecesariamente de la hora del sistema.

Se debe respetar la arquitectura existente antes de introducir nuevas estructuras o patrones.

## 5. Integridad y persistencia de los datos

Los datos del usuario son críticos y deben preservarse ante cualquier modificación del sistema.

**SQLite es la única fuente de verdad para la persistencia de los datos de la aplicación.**

- Todos los datos permanentes deben almacenarse en SQLite mediante la capa de persistencia de Laravel.
- No utilizar `localStorage` como mecanismo alternativo de persistencia de datos.
- Mantener la integridad de los registros y las relaciones entre entidades.
- Cualquier modificación del esquema debe realizarse mediante una nueva migración.
- No modificar migraciones que ya hayan sido ejecutadas.
- Las migraciones deben contemplar la compatibilidad con los datos existentes.
- No eliminar, sobrescribir ni invalidar información sin una justificación funcional y autorización explícita cuando corresponda.
- Las operaciones de eliminación deben respetar las relaciones y restricciones definidas en la base de datos.
- Las fechas deben gestionarse de manera consistente, respetando la hora local y evitando conversiones que alteren el día registrado.
- Los cambios de estructura o comportamiento no deben provocar pérdidas involuntarias de información.

Antes de ejecutar cualquier operación destructiva, el agente debe informar sus consecuencias y solicitar autorización.

## 6. Trazabilidad e historial de cambios

La trazabilidad de las solicitudes es una característica fundamental de Bitácora.

- Los cambios relevantes en las solicitudes deben quedar registrados de acuerdo con las reglas de negocio documentadas.
- El historial debe reflejar fielmente las modificaciones realizadas.
- Los registros históricos no deben generarse manualmente desde controladores, vistas o procesos que eviten el mecanismo establecido en el proyecto.
- No se deben duplicar registros históricos ni registrar modificaciones que no correspondan.
- Los cambios en el mecanismo de auditoría deben preservar la integridad y trazabilidad de los registros existentes.
- Cualquier modificación de las reglas del historial debe estar documentada en la especificación activa.

La trazabilidad no debe sacrificarse por simplificar una implementación.

## 7. Tests y calidad del código

Las pruebas son una condición obligatoria para validar las implementaciones y evitar regresiones.

**PHP y Laravel:**
- Utilizar PHPUnit como framework de pruebas.
- Ejecutar las pruebas mediante `php artisan test`.
- Cubrir las reglas de negocio, validaciones, relaciones, operaciones y comportamientos relevantes.
- Incluir pruebas unitarias y de integración según corresponda.
- Verificar los casos límite y los posibles escenarios de error.

**Calidad y formato:**
- Utilizar Laravel Pint para mantener un formato consistente.
- Ejecutar `vendor/bin/pint --dirty` cuando corresponda.
- No introducir dependencias adicionales para resolver necesidades de testing sin autorización.

**Reglas obligatorias:**
- No considerar terminada una tarea con nuevas pruebas fallidas.
- Investigar y corregir los errores antes de continuar.
- No modificar ni eliminar pruebas únicamente para ocultar errores.
- No introducir regresiones en funcionalidades existentes.
- Diferenciar los errores preexistentes de los introducidos por la implementación actual.
- Toda nueva funcionalidad debe contar con pruebas que validen su comportamiento.

Si una prueba falla por un problema preexistente, debe documentarse y distinguirse claramente de los errores introducidos por el cambio actual.

## 8. Idioma y convenciones

Se debe mantener una separación clara entre el idioma del código y el idioma utilizado por el usuario.

- **Código:** inglés cuando corresponda a convenciones propias del lenguaje o framework, respetando las convenciones de nombres de dominio establecidas en `AGENTS.md`.
- **Interfaz:** español.
- **Validaciones y mensajes:** español.
- **Documentación:** español.
- **Especificaciones, planes y tareas:** español.

Se deben mantener nombres descriptivos, consistentes y fáciles de comprender.

## 9. Alcance y autorización

El agente debe trabajar exclusivamente dentro del alcance solicitado.

- No agregar funcionalidades, rutas, dependencias o comportamientos por iniciativa propia.
- No modificar reglas de autenticación, permisos o seguridad sin autorización.
- No cambiar la arquitectura ni las tecnologías del proyecto sin autorización.
- No realizar modificaciones destructivas sobre datos existentes sin autorización.
- No aprovechar una tarea para realizar refactorizaciones ajenas a su objetivo.
- Si se identifica una mejora fuera del alcance, documentarla y proponerla sin implementarla.

Los cambios deben ser pequeños, enfocados y compatibles con el funcionamiento existente.

## Regla final

**La integridad del proyecto, la coherencia del negocio y el cumplimiento de las especificaciones prevalecen sobre la velocidad de implementación.**

Ante cualquier decisión no documentada, contradicción o incertidumbre que pueda afectar el comportamiento del sistema, el agente debe detenerse y consultar al usuario.

Ninguna implementación se considera terminada hasta que cumpla la especificación activa, respete esta constitución y haya superado las verificaciones correspondientes.