<?php
require_once "config_mysqli.php";

// Iniciar la transacción
mysqli_begin_transaction($conn);

try {
    // Insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $nombre, $email);
    $nombre = "Nuevo Usuario";
    $email = "nuevo@example.com";
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_errno($stmt)) {
        throw new Exception("Error al ejecutar la inserción de usuario: " . mysqli_stmt_error($stmt));
    }

    // Obtener el ID del usuario insertado
    $usuario_id = mysqli_insert_id($conn);

    // Insertar una publicación para ese usuario
    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, "iss", $usuario_id, $titulo, $contenido);
    $titulo = "Nueva Publicación";
    $contenido = "Contenido de la nueva publicación";
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_errno($stmt)) {
        throw new Exception("Error al ejecutar la inserción de publicación: " . mysqli_stmt_error($stmt));
    }

    // Confirmar la transacción
    mysqli_commit($conn);
    echo "Transacción completada con éxito.";

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    mysqli_rollback($conn);
    echo "Error en la transacción: " . $e->getMessage();
}

// Cerrar la conexión
mysqli_close($conn);

  