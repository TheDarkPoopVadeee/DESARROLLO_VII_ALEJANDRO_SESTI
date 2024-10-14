<?php
include 'config_sesion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    // Verificar que el id del producto sea válido
    if ($id > 0) {
        // Inicializar el carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Añadir producto al carrito
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++; // Incrementar la cantidad si ya existe
        } else {
            
            $productos = [
                1 => ['nombre' => 'Producto 1', 'precio' => 10.00],
                2 => ['nombre' => 'Producto 2', 'precio' => 15.00],
                3 => ['nombre' => 'Producto 3', 'precio' => 20.00],
                4 => ['nombre' => 'Producto 4', 'precio' => 25.00],
                5 => ['nombre' => 'Producto 5', 'precio' => 30.00],
            ];

            if (isset($productos[$id])) {
                $_SESSION['carrito'][$id] = [
                    'nombre' => $productos[$id]['nombre'],
                    'precio' => $productos[$id]['precio'],
                    'cantidad' => 1,
                ];
            }
        }
    }
}

header('Location: productos.php'); 
exit();
