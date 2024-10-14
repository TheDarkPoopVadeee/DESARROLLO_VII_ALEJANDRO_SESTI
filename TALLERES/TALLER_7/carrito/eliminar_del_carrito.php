<?php
include 'config_sesion.php'; // Incluir la configuración de sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    // Verificar que el producto exista en el carrito
    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]); // Eliminar el producto del carrito
    }
}

header('Location: ver_carrito.php'); // Redirigir de vuelta al carrito
exit();
