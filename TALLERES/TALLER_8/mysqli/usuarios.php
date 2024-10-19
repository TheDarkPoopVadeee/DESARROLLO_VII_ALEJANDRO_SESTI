<?php
require_once 'config.php';

// Registrar un nuevo usuario
function registrarUsuario($nombre, $email, $password) {
    global $conn;
    
    $password_hash = password_hash($password, PASSWORD_BCRYPT); // Encriptar contraseña
    
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $nombre, $email, $password_hash);
    
    if ($stmt->execute()) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }
}

require_once 'config_mysqli.php'; // Asegúrate de tener la conexión a la base de datos configurada.

function listarUsuarios() {
    global $conn;
    $sql = "SELECT * FROM usuarios";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>" . htmlspecialchars($row['nombre']) . " - " . htmlspecialchars($row['email']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Error al listar usuarios: " . mysqli_error($conn);
    }
}

registrarUsuario('Juan Pérez', 'juan@egmail.com', 'mi_password');
listarUsuarios();
