<?php
require_once 'config.php';

// Registrar un préstamo de un libro a un usuario
function registrarPrestamo($usuario_id, $libro_id) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();
        
        // Insertar el préstamo
        $sql = "INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) 
                VALUES (:usuario_id, :libro_id, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':libro_id' => $libro_id
        ]);
        
        // Actualizar la cantidad de libros disponibles
        $sql = "UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = :libro_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':libro_id' => $libro_id]);
        
        $pdo->commit();
        echo "Préstamo registrado con éxito.";
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error en el registro del préstamo: " . $e->getMessage();
    }
}

registrarPrestamo(1, 1); 
