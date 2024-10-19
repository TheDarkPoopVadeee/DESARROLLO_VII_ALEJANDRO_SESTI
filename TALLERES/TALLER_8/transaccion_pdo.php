<?php
require_once "config_pdo.php";

try {
    // Iniciar transacción
    $pdo->beginTransaction();

    // Insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => 'Nuevo Usuario', ':email' => 'nuevo@example.com']);
    $usuario_id = $pdo->lastInsertId();

    // Verificar si ocurrió algún error en la inserción de usuario
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la inserción de usuario: " . $stmt->errorInfo()[2]);
    }

    // Insertar una publicación para ese usuario
    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => 'Nueva Publicación',
        ':contenido' => 'Contenido de la nueva publicación'
    ]);

    // Verificar si ocurrió algún error en la inserción de la publicación
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error en la inserción de publicación: " . $stmt->errorInfo()[2]);
    }

    // Confirmar transacción
    $pdo->commit();
    echo "Transacción completada con éxito.";

} catch (Exception $e) {
    // Revertir transacción en caso de error
    $pdo->rollBack();
    echo "Error en la transacción: " . $e->getMessage();
}

