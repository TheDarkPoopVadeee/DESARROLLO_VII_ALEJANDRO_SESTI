<?php
// 1. Crear un string JSON con datos de una tienda en línea
$jsonDatos = '
{
    "tienda": "ElectroTech",
    "productos": [
        {"id": 1, "nombre": "Laptop Gamer", "precio": 1200, "categorias": ["electrónica", "computadoras"]},
        {"id": 2, "nombre": "Smartphone 5G", "precio": 800, "categorias": ["electrónica", "celulares"]},
        {"id": 3, "nombre": "Auriculares Bluetooth", "precio": 150, "categorias": ["electrónica", "accesorios"]},
        {"id": 4, "nombre": "Smart TV 4K", "precio": 700, "categorias": ["electrónica", "televisores"]},
        {"id": 5, "nombre": "Tablet", "precio": 300, "categorias": ["electrónica", "computadoras"]}
    ],
    "clientes": [
        {"id": 101, "nombre": "Ana López", "email": "ana@example.com"},
        {"id": 102, "nombre": "Carlos Gómez", "email": "carlos@example.com"},
        {"id": 103, "nombre": "María Rodríguez", "email": "maria@example.com"}
    ]
}
';

// 2. Convertir el JSON a un arreglo asociativo de PHP
$tiendaData = json_decode($jsonDatos, true);

// 3. Función para imprimir los productos
function imprimirProductos($productos) {
    foreach ($productos as $producto) {
        echo "{$producto['nombre']} - ${$producto['precio']} - Categorías: " . implode(", ", $producto['categorias']) . "\n";
    }
}

echo "Productos de {$tiendaData['tienda']}:\n";
imprimirProductos($tiendaData['productos']);

// 4. Calcular el valor total del inventario
$valorTotal = array_reduce($tiendaData['productos'], function($total, $producto) {
    return $total + $producto['precio'];
}, 0);

echo "\nValor total del inventario: $$valorTotal\n";

// 5. Encontrar el producto más caro
$productoMasCaro = array_reduce($tiendaData['productos'], function($max, $producto) {
    return ($producto['precio'] > $max['precio']) ? $producto : $max;
}, $tiendaData['productos'][0]);

echo "\nProducto más caro: {$productoMasCaro['nombre']} (${$productoMasCaro['precio']})\n";

// 6. Filtrar productos por categoría
function filtrarPorCategoria($productos, $categoria) {
    return array_filter($productos, function($producto) use ($categoria) {
        return in_array($categoria, $producto['categorias']);
    });
}

$productosDeComputadoras = filtrarPorCategoria($tiendaData['productos'], "computadoras");
echo "\nProductos en la categoría 'computadoras':\n";
imprimirProductos($productosDeComputadoras);

// 7. Agregar un nuevo producto
$nuevoProducto = [
    "id" => 6,
    "nombre" => "Smartwatch",
    "precio" => 250,
    "categorias" => ["electrónica", "accesorios", "wearables"]
];
$tiendaData['productos'][] = $nuevoProducto;

// 8. Convertir el arreglo actualizado de vuelta a JSON
$jsonActualizado = json_encode($tiendaData, JSON_PRETTY_PRINT);
echo "\nDatos actualizados de la tienda (JSON):\n$jsonActualizado\n";

// TAREA: Implementa una función que genere un resumen de ventas
$ventas = [
    ["producto_id" => 1, "cliente_id" => 101, "cantidad" => 2, "fecha" => "2023-09-01"],
    ["producto_id" => 2, "cliente_id" => 102, "cantidad" => 1, "fecha" => "2023-09-05"],
    ["producto_id" => 3, "cliente_id" => 101, "cantidad" => 3, "fecha" => "2023-09-07"],
    ["producto_id" => 1, "cliente_id" => 103, "cantidad" => 1, "fecha" => "2023-09-10"],
    ["producto_id" => 5, "cliente_id" => 103, "cantidad" => 1, "fecha" => "2023-09-15"]
];

// Función para generar un informe de ventas
function generarInformeVentas($ventas, $productos, $clientes) {
    $totalVentas = 0;
    $ventasPorProducto = [];
    $comprasPorCliente = [];

    // Recorremos las ventas para sumar totales
    foreach ($ventas as $venta) {
        $totalVentas += $venta['cantidad'];

        // Sumar ventas por producto
        if (!isset($ventasPorProducto[$venta['producto_id']])) {
            $ventasPorProducto[$venta['producto_id']] = 0;
        }
        $ventasPorProducto[$venta['producto_id']] += $venta['cantidad'];

        // Sumar compras por cliente
        if (!isset($comprasPorCliente[$venta['cliente_id']])) {
            $comprasPorCliente[$venta['cliente_id']] = 0;
        }
        $comprasPorCliente[$venta['cliente_id']] += $venta['cantidad'];
    }

    // Encontrar el producto más vendido
    $productoMasVendidoId = array_search(max($ventasPorProducto), $ventasPorProducto);
    $productoMasVendido = array_filter($productos, function($producto) use ($productoMasVendidoId) {
        return $producto['id'] == $productoMasVendidoId;
    });
    $productoMasVendido = array_values($productoMasVendido)[0];

    // Encontrar el cliente que más ha comprado
    $clienteMasCompradorId = array_search(max($comprasPorCliente), $comprasPorCliente);
    $clienteMasComprador = array_filter($clientes, function($cliente) use ($clienteMasCompradorId) {
        return $cliente['id'] == $clienteMasCompradorId;
    });
    $clienteMasComprador = array_values($clienteMasComprador)[0];

    // Devolver el informe
    return [
        'total_ventas' => $totalVentas,
        'producto_mas_vendido' => $productoMasVendido['nombre'],
        'cliente_que_mas_compro' => $clienteMasComprador['nombre']
    ];
}

// Generar el informe de ventas
$informeVentas = generarInformeVentas($ventas, $tiendaData['productos'], $tiendaData['clientes']);

// Imprimir el informe de ventas
echo "\nInforme de ventas:\n";
echo "Total de ventas: {$informeVentas['total_ventas']}\n";
echo "Producto más vendido: {$informeVentas['producto_mas_vendido']}\n";
echo "Cliente que más compró: {$informeVentas['cliente_que_mas_compro']}\n";
?>
