<?php
include 'config_sesion.php'; // Incluir la configuración de sesión

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>No hay productos en el carrito.</p>";
    echo '<p><a href="productos.php">Volver a la tienda</a></p>';
    exit();
}

// Inicializar variables para calcular el total
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
</head>
<body>
    <h2>Carrito de Compras</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($_SESSION['carrito'] as $id => $producto): ?>
            <tr>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td><?php echo number_format($producto['precio'], 2); ?> €</td>
                <td><?php echo $producto['cantidad']; ?></td>
                <td><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?> €</td>
                <td>
                    <form method="post" action="eliminar_del_carrito.php">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            <?php
            $total += $producto['precio'] * $producto['cantidad'];
            endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
            <td><?php echo number_format($total, 2); ?> €</td>
            <td></td>
        </tr>
    </table>
    <p><a href="productos.php">Volver a la tienda</a></p>
    <form method="post" action="checkout.php">
        <input type="submit" value="Finalizar Compra">
    </form>
</body>
</html>
