Especificación de Requisitos – SpecTool Comparator API

Objetivo:
Desarrollar una API REST sencilla que permita gestionar y comparar herramientas
de desarrollo basado en especificaciones asistido por IA.

Alcance:
La API permitirá listar herramientas, consultar detalles individuales, añadir
nuevas herramientas y comparar dos herramientas entre sí.

Funcionalidades:
1. Obtener el listado completo de herramientas disponibles.
2. Obtener la información detallada de una herramienta concreta.
3. Añadir una nueva herramienta al sistema.
4. Comparar dos herramientas y devolver una comparación estructurada.

Modelo de datos:
Cada herramienta tendrá los siguientes campos:
- id (entero)
- nombre (string)
- tipo (string: especificación formal o configuración de contexto)
- descripcion (string)
- nivel_madurez (entero de 1 a 5)

Restricciones:
- No se usará base de datos persistente.
- Los datos se almacenarán en memoria.
- La API devolverá respuestas en formato JSON.

Fuera de alcance:
- Autenticación
- Interfaz gráfica compleja
- Integraciones externas