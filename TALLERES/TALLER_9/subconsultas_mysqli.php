<?php
require_once "config_mysqli.php";

// Consulta 1: Encontrar los productos que nunca se han vendido
echo "<h3>Productos que nunca se han vendido:</h3>";
$sql = "SELECT p.nombre 
        FROM productos p 
        WHERE NOT EXISTS (
            SELECT 1 FROM detalles_venta dv WHERE dv.producto_id = p.id
        )";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "Producto: {$row['nombre']}<br>";
}
mysqli_free_result($result);

// Consulta 2: Listar las categorías con el número de productos y el valor total del inventario
echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
$sql = "SELECT c.nombre AS categoria, COUNT(p.id) AS numero_productos, 
               SUM(p.precio * p.stock) AS valor_inventario
        FROM categorias c
        LEFT JOIN productos p ON c.id = p.categoria_id
        GROUP BY c.id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "Categoría: {$row['categoria']}, Número de productos: {$row['numero_productos']}, ";
    echo "Valor total del inventario: $" . $row['valor_inventario'] . "<br>";

}
mysqli_free_result($result);

// Consulta 3: Encontrar los clientes que han comprado todos los productos de una categoría específica
$categoria_id = 1; // Cambia el ID de categoría según lo necesites
echo "<h3>Clientes que han comprado todos los productos de la categoría seleccionada:</h3>";
$sql = "SELECT c.nombre, c.email
        FROM clientes c
        WHERE NOT EXISTS (
            SELECT 1
            FROM productos p
            WHERE p.categoria_id = $categoria_id
            AND NOT EXISTS (
                SELECT 1
                FROM detalles_venta dv
                JOIN ventas v ON dv.venta_id = v.id
                WHERE v.cliente_id = c.id
                AND dv.producto_id = p.id
            )
        )";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "Cliente: {$row['nombre']}, Email: {$row['email']}<br>";
}
mysqli_free_result($result);

// Consulta 4: Calcular el porcentaje de ventas de cada producto respecto al total de ventas
echo "<h3>Porcentaje de ventas de cada producto respecto al total:</h3>";
$sql = "SELECT p.nombre, SUM(dv.subtotal) AS total_producto,
               (SUM(dv.subtotal) / (SELECT SUM(subtotal) FROM detalles_venta) * 100) AS porcentaje_ventas
        FROM productos p
        JOIN detalles_venta dv ON p.id = dv.producto_id
        GROUP BY p.id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "Producto: " . $row['nombre'] . ", Total ventas: $" . $row['total_producto'] . ", ";
    echo "Porcentaje del total: {$row['porcentaje_ventas']}%<br>";
}
mysqli_free_result($result);

mysqli_close($conn);

