<?php
include 'config_sesion.php'; // Incluir configuración de sesión

// Lista de productos
$productos = [
    1 => ['nombre' => 'Remolacha', 'precio' => 10.00],
    2 => ['nombre' => 'Zapallo', 'precio' => 15.00],
    3 => ['nombre' => 'Sandia', 'precio' => 20.00],
    4 => ['nombre' => 'Banana', 'precio' => 25.00],
    5 => ['nombre' => 'Guandu', 'precio' => 30.00],
];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
</head>
<body>
    <h2>Tienda de Productos</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($productos as $id => $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td><?php echo number_format($producto['precio'], 2); ?> €</td>
                <td>
                    <form method="post" action="agregar_al_carrito.php">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" value="Añadir al Carrito">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="ver_carrito.php">Ver Carrito</a></p>
</body>
</html>
