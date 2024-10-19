<?php
require_once 'config.php';

// Función para registrar un nuevo préstamo
function registrarPrestamo($usuario_id, $libro_id) {
    global $conn;

    try {
        // Iniciar una transacción
        mysqli_begin_transaction($conn);

        // Insertar el nuevo préstamo
        $sql = "INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $usuario_id, $libro_id);
        mysqli_stmt_execute($stmt);

        // Actualizar la cantidad de libros disponibles
        $sql = "UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $libro_id);
        mysqli_stmt_execute($stmt);

        // Si todo va bien, confirmar la transacción
        mysqli_commit($conn);
        echo "Préstamo registrado con éxito.";

    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        mysqli_rollback($conn);
        echo "Error en el registro del préstamo: " . $e->getMessage();
    }
}

// Función para listar todos los préstamos activos
function listarPrestamos() {
    global $conn;

    $sql = "SELECT prestamos.id, usuarios.nombre AS usuario, libros.titulo AS libro, prestamos.fecha_prestamo 
            FROM prestamos 
            JOIN usuarios ON prestamos.usuario_id = usuarios.id 
            JOIN libros ON prestamos.libro_id = libros.id 
            WHERE prestamos.fecha_devolucion IS NULL";
    
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Préstamo ID: " . $row['id'] . " | Usuario: " . $row['usuario'] . " | Libro: " . $row['libro'] . " | Fecha: " . $row['fecha_prestamo'] . "<br>";
        }
    } else {
        echo "No hay préstamos activos.";
    }
}

// Función para registrar la devolución de un libro
function registrarDevolucion($prestamo_id, $libro_id) {
    global $conn;

    try {
        // Iniciar una transacción
        mysqli_begin_transaction($conn);

        // Actualizar el préstamo para marcar la devolución
        $sql = "UPDATE prestamos SET fecha_devolucion = NOW() WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $prestamo_id);
        mysqli_stmt_execute($stmt);

        // Actualizar la cantidad de libros disponibles
        $sql = "UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $libro_id);
        mysqli_stmt_execute($stmt);

        // Confirmar la transacción
        mysqli_commit($conn);
        echo "Devolución registrada con éxito.";

    } catch (Exception $e) {
        // Revertir en caso de error
        mysqli_rollback($conn);
        echo "Error al registrar la devolución: " . $e->getMessage();
    }
}

// Función para mostrar el historial de préstamos por usuario
function historialPrestamos($usuario_id) {
    global $conn;

    $sql = "SELECT prestamos.id, libros.titulo AS libro, prestamos.fecha_prestamo, prestamos.fecha_devolucion
            FROM prestamos
            JOIN libros ON prestamos.libro_id = libros.id
            WHERE prestamos.usuario_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Préstamo ID: " . $row['id'] . " | Libro: " . $row['libro'] . " | Fecha de Préstamo: " . $row['fecha_prestamo'] . " | Fecha de Devolución: " . ($row['fecha_devolucion'] ?: 'Pendiente') . "<br>";
        }
    } else {
        echo "Este usuario no tiene préstamos registrados.";
    }
}
