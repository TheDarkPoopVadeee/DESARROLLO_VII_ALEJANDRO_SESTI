<?php
require_once "config_mysqli.php";

// 1. Procedimiento para procesar una devolución de producto
function procesarDevolucion($conn, $venta_id, $producto_id, $cantidad) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?, @mensaje)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $venta_id, $producto_id, $cantidad);
    
    $stmt->execute();
    
    // Obtener el mensaje de la devolución
    $result = $conn->query("SELECT @mensaje AS mensaje");
    $row = $result->fetch_assoc();
    
    echo $row['mensaje'];
    
    $stmt->close();
}

// 2. Procedimiento para calcular y aplicar descuentos basados en el historial de compras del cliente
function aplicarDescuento($conn, $cliente_id) {
    $query = "CALL sp_aplicar_descuento(?, @descuento)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    
    $stmt->execute();
    
    // Obtener el descuento
    $result = $conn->query("SELECT @descuento AS descuento");
    $row = $result->fetch_assoc();
    
    echo "Descuento aplicado: " . ($row['descuento'] * 100) . "%";
    
    $stmt->close();
}

// 3. Procedimiento para generar un reporte de productos con bajo stock y sugerir cantidades de reposición
function reporteBajoStock($conn) {
    $query = "CALL sp_reporte_bajo_stock()";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        echo "Producto: " . $row['nombre'] . "<br>";
        echo "Stock actual: " . $row['stock'] . "<br>";
        echo "Cantidad a reponer: " . $row['cantidad_reponer'] . "<br><br>";
    }
}

// 4. Procedimiento para calcular comisiones por ventas basadas en diferentes criterios (monto total, cantidad de productos, etc.)
function calcularComisiones($conn, $vendedor_id) {
    $query = "CALL sp_calcular_comisiones(?, @comision)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $vendedor_id);
    
    $stmt->execute();
    
    // Obtener la comisión
    $result = $conn->query("SELECT @comision AS comision");
    $row = $result->fetch_assoc();
    
    echo "Comisión: $" . $row['comision'];
    
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
