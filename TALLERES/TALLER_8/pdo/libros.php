<?php
require_once 'config.php';

// Añadir un nuevo libro
function añadirLibro($titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible) {
    global $pdo;
    $sql = "INSERT INTO libros (titulo, autor, isbn, ano_publicacion, cantidad_disponible) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible]);
}

// Listar todos los libros
function listarLibros() {
    global $pdo;
    $sql = "SELECT * FROM libros";
    $stmt = $pdo->query($sql);
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<ul>";
    foreach ($libros as $libro) {
        echo "<li>{$libro['titulo']} por {$libro['autor']} (ISBN: {$libro['isbn']})</li>";
    }
    echo "</ul>";
}
