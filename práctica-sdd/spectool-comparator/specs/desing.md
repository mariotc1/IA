Diseño de la API – SpecTool Comparator API

Arquitectura:
La aplicación seguirá una arquitectura simple basada en Flask.
Toda la lógica se concentrará en un único archivo para facilitar la comprensión.

Endpoints definidos:

1. GET /tools
   Devuelve la lista completa de herramientas.

2. GET /tools/<id>
   Devuelve la información detallada de una herramienta.

3. POST /tools
   Permite añadir una nueva herramienta mediante un JSON.

4. GET /compare
   Compara dos herramientas usando parámetros query (?toolA= & toolB=).

Estructura interna:
- Una lista en memoria almacenará las herramientas.
- Cada endpoint operará sobre esta lista.
- Se validarán los datos básicos de entrada.

Formato de respuesta:
Todas las respuestas se devolverán en JSON con códigos HTTP apropiados.