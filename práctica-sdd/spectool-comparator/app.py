from flask import Flask, jsonify, request, abort

app = Flask(__name__)

# Datos en memoria (simulación de base de datos)
herramientas = [
    {
        "id": 1,
        "nombre": "Spec-kit",
        "tipo": "Especificación formal",
        "descripcion": "Herramienta open source para desarrollo basado en especificaciones.",
        "nivel_madurez": 4
    },
    {
        "id": 2,
        "nombre": "OpenSpec",
        "tipo": "Especificación formal",
        "descripcion": "Solución ligera para añadir especificaciones a proyectos existentes.",
        "nivel_madurez": 3
    },
    {
        "id": 3,
        "nombre": "Cursor Rules",
        "tipo": "Configuración de contexto",
        "descripcion": "Archivo de reglas para guiar agentes de IA en el editor.",
        "nivel_madurez": 5
    }
]


@app.route("/tools", methods=["GET"])
def obtener_herramientas():
    """Devuelve la lista completa de herramientas"""
    return jsonify(herramientas)


@app.route("/tools/<int:tool_id>", methods=["GET"])
def obtener_herramienta(tool_id):
    """Devuelve una herramienta por su ID"""
    herramienta = next((h for h in herramientas if h["id"] == tool_id), None)
    if herramienta is None:
        abort(404, description="Herramienta no encontrada")
    return jsonify(herramienta)


@app.route("/tools", methods=["POST"])
def crear_herramienta():
    """Añade una nueva herramienta"""
    datos = request.get_json()

    if not datos:
        abort(400, description="Datos JSON inválidos")

    campos_requeridos = ["nombre", "tipo", "descripcion", "nivel_madurez"]
    if not all(campo in datos for campo in campos_requeridos):
        abort(400, description="Faltan campos obligatorios")

    nueva_herramienta = {
        "id": len(herramientas) + 1,
        "nombre": datos["nombre"],
        "tipo": datos["tipo"],
        "descripcion": datos["descripcion"],
        "nivel_madurez": datos["nivel_madurez"]
    }

    herramientas.append(nueva_herramienta)
    return jsonify(nueva_herramienta), 201


@app.route("/compare", methods=["GET"])
def comparar_herramientas():
    """Compara dos herramientas"""
    nombre_a = request.args.get("toolA")
    nombre_b = request.args.get("toolB")

    if not nombre_a or not nombre_b:
        abort(400, description="Se requieren los parámetros toolA y toolB")

    herramienta_a = next((h for h in herramientas if h["nombre"] == nombre_a), None)
    herramienta_b = next((h for h in herramientas if h["nombre"] == nombre_b), None)

    if not herramienta_a or not herramienta_b:
        abort(404, description="Una o ambas herramientas no existen")

    comparacion = {
        "herramienta_A": herramienta_a["nombre"],
        "herramienta_B": herramienta_b["nombre"],
        "diferencia_madurez": herramienta_a["nivel_madurez"] - herramienta_b["nivel_madurez"],
        "tipo_A": herramienta_a["tipo"],
        "tipo_B": herramienta_b["tipo"]
    }

    return jsonify(comparacion)


if __name__ == "__main__":
    app.run(debug=True)