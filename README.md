# 🚀 AstroFinance - Personal Expense Tracker

![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Status](https://img.shields.io/badge/Status-Active-success?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)

**AstroFinance** es una aplicación web de gestión de gastos personales diseñada con una estética futurista "Glassmorphism" y principios de **Green Coding**. Permite a los usuarios registrar, visualizar y analizar sus finanzas de manera privada y segura.

---

## ✨ Características Principales

- **🎨 Diseño Futurista**: Interfaz de usuario inmersiva con efectos de cristal (Glassmorphism), gradientes dinámicos y diseño totalmente responsive (Mobile/Desktop).
- **🔒 Privacidad Total**: Arquitectura aislada donde cada usuario solo puede acceder a sus propios datos.
- **⚡ Green Coding**: Sistema de **Query Caching** implementado para minimizar la carga en base de datos y reducir la huella de carbono digital en operaciones de lectura frecuentes.
- **📊 Análisis Visual**: Gráficos interactivos generados en tiempo real con Chart.js.
- **� SPA-like Experience**: Navegación y operaciones CRUD asíncronas (AJAX/Fetch) sin recargas de página.

---

## 🛠 Stack Tecnológico

La aplicación ha sido construida siguiendo el patrón arquitectónico **MVC (Modelo-Vista-Controlador)** sin dependencias de frameworks pesados para maximizar el rendimiento.

| Componente          | Tecnología              | Descripción                                           |
| ------------------- | ----------------------- | ----------------------------------------------------- |
| **Backend**         | PHP 8.2 (Nativo)        | Lógica de negocio, auntenticación y manejo de sesión. |
| **Bases de Datos**  | MariaDB 10.6            | Almacenamiento relacional persistente.                |
| **Frontend**        | HTML5, CSS3, JS Vanilla | Interfaz de usuario con CSS Variables y Fetch API.    |
| **Infraestructura** | Docker & Docker Compose | Contenedorización para despliegue consistente.        |
| **Librerías**       | Chart.js                | Visualización de datos (Gráficos).                    |

---

## 📥 Instalación y Ejecución

La forma recomendada de ejecutar este proyecto es mediante **Docker**, lo que garantiza que todas las dependencias estén configuradas correctamente.

### Prerrequisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado y ejecutándose.

### Pasos Rápidos

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/tu-usuario/gestor-gastos.git
   cd gestor-gastos
   ```

2. **Iniciar la aplicación**

   ```bash
   docker compose up -d --build
   ```

   > Este comando descargará las imágenes necesarias, construirá el entorno y levantará los servicios de base de datos y servidor web automáticamente.

3. **Acceder**
   Abre tu navegador y visita:
   👉 **[http://localhost:8080](http://localhost:8080)**

---

## � Estructura del Proyecto

El código está organizado para ser escalable y mantenible:

```
gestor-gastos/
├── app/
│   ├── Controllers/    # Lógica de negocio (Login, Dashboard, Gastos)
│   ├── Core/           # Framework propio (Router, Database, Cache)
│   ├── Models/         # Interacción con datos
│   └── Views/          # Plantillas HTML/PHP renderizadas
├── public/
│   ├── assets/         # CSS y JS compilados
│   └── index.php       # Punto de entrada único
├── database/
│   └── schema.sql      # Definición de tablas y datos semilla
├── docker-compose.yml  # Orquestación de contenedores
└── Dockerfile          # Configuración de imagen PHP/Apache
```

---

## 🌿 Estrategia Green Coding

Este proyecto implementa prácticas de desarrollo sostenible de software:

1.  **Cacheo de Totales**: Las operaciones matemáticas costosas (como sumar todos los gastos por categoría) se calculan una vez y se almacenan en archivos JSON ligeros.
2.  **Invalidación Inteligente**: La caché solo se regenera cuando un usuario añade o elimina un gasto, evitando ciclos de CPU innecesarios en lecturas repetitivas.
3.  **Frontend Optimizado**: Uso de CSS nativo y JS Vanilla para evitar la sobrecarga de descarga de librerías JS masivas.

---

## � Seguridad

- **Contraseñas**: Hashed usando BCrypt (`password_hash`).
- **Sesiones**: Gestión segura mediante `$_SESSION` y cookies HTTP-only.
- **Sanitización**: Todas las entradas SQL utilizan **Prepared Statements** (PDO) para prevenir inyecciones SQL.
- **XSS**: Escapado de output en vistas (`htmlspecialchars`).

---

<p align="center">
  <sub>Desarrollado para el módulo de Desarrollo Web en Entorno Servidor.</sub>
</p>
