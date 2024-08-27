<?php
// Función para obtener un array de libros
function obtenerLibros() {
    return [
        [
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'anio_publicacion' => 1605,
            'genero' => 'Novela',
            'descripcion' => 'La historia del ingenioso hidalgo Don Quijote de la Mancha.'
        ],
        [
            'titulo' => 'Cien años de soledad',
            'autor' => 'Gabriel García Márquez',
            'anio_publicacion' => 1967,
            'genero' => 'Realismo mágico',
            'descripcion' => 'La novela narra la historia de la familia Buendía en el pueblo ficticio de Macondo.'
        ],
        [
            'titulo' => '1984',
            'autor' => 'George Orwell',
            'anio_publicacion' => 1949,
            'genero' => 'Distopía',
            'descripcion' => 'Una novela que explora la vigilancia y el totalitarismo en un futuro distópico.'
        ],
        [
            'titulo' => 'El gran Gatsby',
            'autor' => 'F. Scott Fitzgerald',
            'anio_publicacion' => 1925,
            'genero' => 'Novela',
            'descripcion' => 'La historia de Jay Gatsby y su búsqueda del sueño americano en la década de 1920.'
        ],
        [
            'titulo' => 'Matar a un ruiseñor',
            'autor' => 'Harper Lee',
            'anio_publicacion' => 1960,
            'genero' => 'Ficción',
            'descripcion' => 'Una novela sobre la injusticia racial en el sur de los Estados Unidos durante la Gran Depresión.'
        ]
    ];
}

// Función para mostrar los detalles de un libro en formato HTML
function mostrarDetallesLibro($libro) {
    return '
        <div>
            <h2>' . htmlspecialchars($libro['titulo']) . '</h2>
            <p><strong>Autor:</strong> ' . htmlspecialchars($libro['autor']) . '</p>
            <p><strong>Año de Publicación:</strong> ' . htmlspecialchars($libro['anio_publicacion']) . '</p>
            <p><strong>Género:</strong> ' . htmlspecialchars($libro['genero']) . '</p>
            <p><strong>Descripción:</strong> ' . htmlspecialchars($libro['descripcion']) . '</p>
        </div>
    ';
}

// Obtener los libros
$libros = obtenerLibros();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Libros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .book-detail {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Detalles de los Libros</h1>
    <?php foreach ($libros as $libro): ?>
        <div class="book-detail">
            <?php echo mostrarDetallesLibro($libro); ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
