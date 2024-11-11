<?php
require_once "config_pdo.php";

// 1. Productos con bajo stock
function mostrarProductosBajoStock($pdo) {
    $stmt = $pdo->query("SELECT * FROM vista_productos_bajo_stock");
    echo "<h3>Productos con Bajo Stock:</h3><table border='1'><tr><th>Producto</th><th>Categoría</th><th>Stock</th><th>Total Vendido</th><th>Ingresos Totales</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['producto']}</td><td>{$row['categoria']}</td><td>{$row['stock']}</td><td>{$row['total_vendido']}</td><td>{$row['ingresos_totales']}</td></tr>";
    }
    echo "</table>";
}

// 2. Historial completo de cada cliente
function mostrarHistorialClientes($pdo) {
    $stmt = $pdo->query("SELECT * FROM vista_historial_clientes");
    echo "<h3>Historial de Clientes:</h3><table border='1'><tr><th>Cliente</th><th>Producto</th><th>Cantidad</th><th>Monto Gastado</th><th>Fecha Venta</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['cliente']}</td><td>{$row['producto']}</td><td>{$row['cantidad']}</td><td>{$row['monto_gastado']}</td><td>{$row['fecha_venta']}</td></tr>";
    }
    echo "</table>";
}

// 3. Métricas de rendimiento por categoría
function mostrarRendimientoPorCategoria($pdo) {
    $stmt = $pdo->query("SELECT * FROM vista_rendimiento_por_categoria");
    echo "<h3>Rendimiento por Categoría:</h3><table border='1'><tr><th>Categoría</th><th>Total Productos</th><th>Cantidad Vendida</th><th>Ingresos Totales</th><th>Producto Más Vendido</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['categoria']}</td><td>{$row['total_productos']}</td><td>{$row['cantidad_total_vendida']}</td><td>{$row['ingresos_totales']}</td><td>{$row['producto_mas_vendido']}</td></tr>";
    }
    echo "</table>";
}

// 4. Tendencias de ventas por mes
function mostrarTendenciasVentasMes($pdo) {
    $stmt = $pdo->query("SELECT * FROM vista_tendencias_ventas_mes");
    echo "<h3>Tendencias de Ventas por Mes:</h3><table border='1'><tr><th>Mes</th><th>Ingresos Totales</th><th>Total Ventas</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['mes']}</td><td>{$row['ingresos_totales']}</td><td>{$row['total_ventas']}</td></tr>";
    }
    echo "</table>";
}

// Llamadas a funciones
mostrarProductosBajoStock($pdo);
mostrarHistorialClientes($pdo);
mostrarRendimientoPorCategoria($pdo);
mostrarTendenciasVentasMes($pdo);

$pdo = null;
?>
