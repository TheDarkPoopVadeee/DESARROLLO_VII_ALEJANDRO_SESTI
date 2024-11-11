<?php
require_once "config_pdo.php"; // O usar mysqli según prefieras

// Función para verificar actualización del nivel de membresía del cliente
function verificarMembresiaCliente($pdo, $cliente_id) {
    try {
        // Obtener el nivel de membresía actual
        $stmt = $pdo->prepare("SELECT nivel_membresia FROM clientes WHERE id = ?");
        $stmt->execute([$cliente_id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Nivel de Membresía del Cliente:</h3>";
        echo "Cliente ID: " . $cliente_id . "<br>";
        echo "Nivel de Membresía: " . $cliente['nivel_membresia'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para verificar estadísticas de ventas por categoría
function verificarEstadisticasCategoria($pdo, $categoria_id) {
    try {
        // Obtener las estadísticas de ventas por categoría
        $stmt = $pdo->prepare("SELECT total_ventas FROM estadisticas_categoria WHERE categoria_id = ?");
        $stmt->execute([$categoria_id]);
        $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Estadísticas de Ventas por Categoría:</h3>";
        echo "Categoría ID: " . $categoria_id . "<br>";
        echo "Total de Ventas: $" . $estadisticas['total_ventas'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para verificar alerta de stock crítico
function verificarAlertaStockCritico($pdo, $producto_id) {
    try {
        // Obtener las alertas de stock
        $stmt = $pdo->prepare("SELECT * FROM alertas_stock WHERE producto_id = ? ORDER BY fecha_alerta DESC LIMIT 1");
        $stmt->execute([$producto_id]);
        $alerta = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Alerta de Stock Crítico:</h3>";
        echo "Producto ID: " . $producto_id . "<br>";
        echo "Mensaje: " . $alerta['mensaje'] . "<br>";
        echo "Fecha de Alerta: " . $alerta['fecha_alerta'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Función para verificar historial de cambios de estado de cliente
function verificarHistorialEstadoCliente($pdo, $cliente_id) {
    try {
        // Obtener historial de cambios de estado
        $stmt = $pdo->prepare("SELECT * FROM historial_estado_cliente WHERE cliente_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
        $stmt->execute([$cliente_id]);
        $historial = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Historial de Estado del Cliente:</h3>";
        echo "Cliente ID: " . $cliente_id . "<br>";
        echo "Estado Anterior: " . $historial['estado_anterior'] . "<br>";
        echo "Estado Nuevo: " . $historial['estado_nuevo'] . "<br>";
        echo "Fecha de Cambio: " . $historial['fecha_cambio'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Probar los triggers
verificarMembresiaCliente($pdo, 1);
verificarEstadisticasCategoria($pdo, 2);
verificarAlertaStockCritico($pdo, 1);
verificarHistorialEstadoCliente($pdo, 3);

$pdo = null;
?>
