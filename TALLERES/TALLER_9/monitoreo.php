<?php
require_once "config_pdo.php";

function obtenerEstadisticasTabla($pdo, $tabla) {
    try {
        $sql = "SHOW TABLE STATUS LIKE :tabla";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':tabla' => $tabla]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

function obtenerEstadisticasIndices($pdo, $tabla) {
    try {
        $sql = "SHOW INDEX FROM " . $tabla;
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

$tablas = ['productos', 'ventas', 'detalles_venta', 'clientes'];
foreach ($tablas as $tabla) {
    echo "<h3>Estadísticas para la tabla: $tabla</h3>";
    $estadisticas = obtenerEstadisticasTabla($pdo, $tabla);
    print_r($estadisticas);
    
    echo "<h4>Índices para la tabla: $tabla</h4>";
    $indices = obtenerEstadisticasIndices($pdo, $tabla);
    print_r($indices);
}

$pdo = null;

?>