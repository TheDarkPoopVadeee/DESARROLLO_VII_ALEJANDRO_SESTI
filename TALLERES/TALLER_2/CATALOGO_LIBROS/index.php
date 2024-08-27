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
        ]
    ];
}

// Obtener la lista de libros
$libros = obtenerLibros();

// Incluir el encabezado
include 'header.php';
?>

<h1>Lista de Libros</h1>
<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Año de Publicación</th>
            <th>Género</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($libros as $libro): ?>
            <tr>
                <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                <td><?php echo htmlspecialchars($libro['anio_publicacion']); ?></td>
                <td><?php echo htmlspecialchars($libro['genero']); ?></td>
                <td class="descripcion"><?php echo htmlspecialchars($libro['descripcion']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
// Incluir el pie de página
include 'footer.php';
?>
