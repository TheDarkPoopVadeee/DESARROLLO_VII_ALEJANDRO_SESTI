<?php
require_once 'config.php';

// Registrar un nuevo usuario
function registrarUsuario($nombre, $email, $contraseña) {
    global $pdo;
    $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $email, password_hash($contraseña, PASSWORD_DEFAULT)]);
}

// Listar todos los usuarios
function listarUsuarios() {
    global $pdo;
    $sql = "SELECT * FROM usuarios";
    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<ul>";
    foreach ($usuarios as $usuario) {
        echo "<li>{$usuario['nombre']} (Email: {$usuario['email']})</li>";
    }
    echo "</ul>";
}
