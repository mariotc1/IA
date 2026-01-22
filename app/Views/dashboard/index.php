<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AstroFinance</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="container navbar">
        <div class="logo">AstroFinance</div>
        <div class="nav-links">
            <span style="margin-right: 20px;">Hola,
                <?= htmlspecialchars($user_name) ?>
            </span>
            <a href="/logout">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container">
        <!-- Filters -->
        <div class="glass-card form-group" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 24px;">
            <div style="flex: 1; min-width: 200px;">
                <label>Categoría</label>
                <select id="filterCategory">
                    <option value="">Todas</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label>Desde</label>
                <input type="date" id="filterFrom">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label>Hasta</label>
                <input type="date" id="filterTo">
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Left: Add Expense -->
            <div>
                <div class="glass-card">
                    <h3 style="margin-bottom: 20px;">Nuevo Gasto</h3>
                    <form id="addExpenseForm">
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="number" step="0.01" name="amount" required placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label>Categoría</label>
                            <select name="category_id" required>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>">
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" name="date" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="form-group">
                            <label>Ubicación (Opcional)</label>
                            <input type="text" name="location" placeholder="Ej. Supermercado">
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" name="description" placeholder="Detalles del gasto">
                        </div>
                        <button type="submit" class="btn btn-block">Añadir Gasto</button>
                    </form>
                </div>
            </div>

            <!-- Right: Stats & List -->
            <div>
                <div class="glass-card" style="margin-bottom: 24px;">
                    <h3 style="margin-bottom: 20px;">Distribución de Gastos</h3>
                    <div class="chart-container">
                        <canvas id="expenseChart"></canvas>
                    </div>
                </div>

                <div class="glass-card">
                    <h3 style="margin-bottom: 20px;">Historial Reciente</h3>
                    <div style="overflow-x: auto;">
                        <table class="expense-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Categoría</th>
                                    <th>Desc.</th>
                                    <th>Monto</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="expenseListBody">
                                <!-- JS Populated -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/app.js"></script>
</body>

</html>