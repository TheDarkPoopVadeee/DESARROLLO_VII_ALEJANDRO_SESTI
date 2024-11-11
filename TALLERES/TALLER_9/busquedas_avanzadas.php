<?php
function busquedaAvanzada($pdo, array $criterios) {
    $qb = new QueryBuilder($pdo);
    $qb->table('productos p')
       ->select('p.*', 'c.nombre as categoria')
       ->join('categorias c', 'p.categoria_id', '=', 'c.id');

    // Aplicar filtros dinámicamente
    if (isset($criterios['nombre'])) {
        $qb->where('p.nombre', 'LIKE', '%' . $criterios['nombre'] . '%');
    }

    if (isset($criterios['precio_min'])) {
        $qb->where('p.precio', '>=', $criterios['precio_min']);
    }

    if (isset($criterios['precio_max'])) {
        $qb->where('p.precio', '<=', $criterios['precio_max']);
    }

    if (isset($criterios['categorias']) && is_array($criterios['categorias'])) {
        $qb->whereIn('c.id', $criterios['categorias']);
    }

    return $qb->execute();
}

// Ejemplo de uso:
require_once "config_pdo.php";

$criterios = [
    'nombre' => 'Laptop',
    'precio_min' => 500,
    'precio_max' => 1500,
    'categorias' => [1, 3]
];

$resultados = busquedaAvanzada($pdo, $criterios);

// Mostrar resultados
echo "<pre>";
print_r($resultados);
echo "</pre>";
?>
