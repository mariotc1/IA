<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - AstroFinance</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
        <div class="glass-card" style="width: 100%; max-width: 400px;">
            <h2 style="text-align: center; margin-bottom: 30px;">Crear Cuenta</h2>

            <?php if (isset($_GET['error'])): ?>
                <div
                    style="background: rgba(255,0,85,0.1); color: var(--danger); padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                    Error al registrar</div>
            <?php endif; ?>

            <form action="/register" method="POST">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="name" required placeholder="Tu Nombre">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="tu@email.com">
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-block">Registrarse</button>
            </form>
            <p style="text-align: center; margin-top: 20px; font-size: 0.9rem;">
                ¿Ya tienes cuenta? <a href="/login">Inicia Sesión</a>
            </p>
        </div>
    </div>
</body>

</html>