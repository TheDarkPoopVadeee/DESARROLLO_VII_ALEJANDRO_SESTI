<?php
include 'config_sesion.php'; // Incluir la configuración de sesión

// Verificar si hay productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>No hay productos en el carrito.</p>";
    echo '<p><a href="productos.php">Volver a la tienda</a></p>';
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Compra</title>
</head>
<body>
    <h2>Resumen de Compra</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($_SESSION['carrito'] as $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td><?php echo number_format($producto['precio'], 2); ?> €</td>
                <td><?php echo $producto['cantidad']; ?></td>
                <td><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?> €</td>
            </tr>
            <?php
            $total += $producto['precio'] * $producto['cantidad'];
            endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
            <td><?php echo number_format($total, 2); ?> €</td>
        </tr>
    </table>

    <?php
    // Guardar el nombre del usuario en una cookie por 24 horas
    if (isset($_SESSION['usuario'])) {
        setcookie('usuario', $_SESSION['usuario'], time() + (86400), "/"); // 86400 segundos = 1 día
    }

    // Vaciar el carrito
    unset($_SESSION['carrito']);
    ?>

    <p>¡Gracias por tu compra!</p>
    <p><a href="productos.php">Volver a la tienda</a></p>
</body>
</html>
