<?php
require_once 'config_mysqli.php'; // Asegúrate de que la conexión esté configurada

function añadirLibro($titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible) {
    global $conn;
    $sql = "INSERT INTO libros (titulo, autor, isbn, ano_publicacion, cantidad_disponible) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssii", $titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible);

    if (mysqli_stmt_execute($stmt)) {
        echo "Libro añadido exitosamente.";
    } else {
        echo "Error al añadir el libro: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

function listarLibros() {
    global $conn;
    $sql = "SELECT * FROM libros";
    $result = mysqli_query($conn, $sql);

    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>" . $row['titulo'] . " - " . $row['autor'] . " (" . $row['ano_publicacion'] . ")</li>";
    }
    echo "</ul>";
}
