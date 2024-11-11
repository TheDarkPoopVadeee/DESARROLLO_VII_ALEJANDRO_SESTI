<?php
require_once "config_pdo.php";

// 1. Procedimiento para procesar una devolución de producto
function procesarDevolucion($pdo, $venta_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_procesar_devolucion(:venta_id, :producto_id, :cantidad, @mensaje)");
        $stmt->bindParam(':venta_id', $venta_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        
        $stmt->execute();
        
        // Obtener el mensaje de la devolución
        $result = $pdo->query("SELECT @mensaje AS mensaje")->fetch(PDO::FETCH_ASSOC);
        echo $result['mensaje'];
    } catch (PDOException $e) {
        echo "Error al procesar la devolución: " . $e->getMessage();
    }
}

// 2. Procedimiento para calcular y aplicar descuentos basados en el historial de compras del cliente
function aplicarDescuento($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_aplicar_descuento(:cliente_id, @descuento)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        // Obtener el descuento
        $result = $pdo->query("SELECT @descuento AS descuento")->fetch(PDO::FETCH_ASSOC);
        echo "Descuento aplicado: " . ($result['descuento'] * 100) . "%";
    } catch (PDOException $e) {
        echo "Error al aplicar el descuento: " . $e->getMessage();
    }
}

// 3. Procedimiento para generar un reporte de productos con bajo stock y sugerir cantidades de reposición
function reporteBajoStock($pdo) {
    try {
        $stmt = $pdo->prepare("CALL sp_reporte_bajo_stock()");
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Producto: " . $row['nombre'] . "<br>";
            echo "Stock actual: " . $row['stock'] . "<br>";
            echo "Cantidad a reponer: " . $row['cantidad_reponer'] . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Error al generar el reporte de bajo stock: " . $e->getMessage();
    }
}

// 4. Procedimiento para calcular comisiones por ventas basadas en diferentes criterios (monto total, cantidad de productos, etc.)
function calcularComisiones($pdo, $vendedor_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_calcular_comisiones(:vendedor_id, @comision)");
        $stmt->bindParam(':vendedor_id', $vendedor_id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        // Obtener la comisión
        $result = $pdo->query("SELECT @comision AS comision")->fetch(PDO::FETCH_ASSOC);
        echo "Comisión: $" . $result['comision'];
    } catch (PDOException $e) {
        echo "Error al calcular la comisión: " . $e->getMessage();
    }
}

// Cerrar la conexión
$pdo = null;

?>