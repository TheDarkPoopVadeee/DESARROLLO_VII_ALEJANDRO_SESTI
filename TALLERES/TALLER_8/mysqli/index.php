<?php
require_once 'libros.php';
require_once 'usuarios.php';
require_once 'prestamos.php';

// Si es una solicitud POST (cuando se envían datos a través de un formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determinar la acción basada en el campo "action"
    $action = $_POST['action'];

    switch ($action) {
        case 'add_libro':
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $isbn = $_POST['isbn'];
            $ano_publicacion = $_POST['ano_publicacion'];
            $cantidad_disponible = $_POST['cantidad_disponible'];
            añadirLibro($titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible);
            break;

        case 'add_usuario':
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $contraseña = $_POST['contraseña'];
            registrarUsuario($nombre, $email, $contraseña);
            break;

        case 'prestamo_libro':
            $usuario_id = $_POST['usuario_id'];
            $libro_id = $_POST['libro_id'];
            registrarPrestamo($usuario_id, $libro_id);
            break;

        case 'devolucion_libro':
            $prestamo_id = $_POST['prestamo_id'];
            $libro_id = $_POST['libro_id'];
            registrarDevolucion($prestamo_id, $libro_id);
            break;

        default:
            echo "Acción no válida.";
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Biblioteca</title>
</head>
<body>
    <h1>Sistema de Gestión de Biblioteca</h1>

    <!-- Formulario para añadir un nuevo libro -->
    <h2>Añadir Nuevo Libro</h2>
    <form method="POST" action="index.php">
        <input type="hidden" name="action" value="add_libro">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required><br>
        <label for="autor">Autor:</label>
        <input type="text" name="autor" required><br>
        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required><br>
        <label for="ano_publicacion">Año de Publicación:</label>
        <input type="number" name="ano_publicacion" required><br>
        <label for="cantidad_disponible">Cantidad Disponible:</label>
        <input type="number" name="cantidad_disponible" required><br>
        <button type="submit">Añadir Libro</button>
    </form>

    <!-- Formulario para registrar un nuevo usuario -->
    <h2>Registrar Nuevo Usuario</h2>
    <form method="POST" action="index.php">
        <input type="hidden" name="action" value="add_usuario">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required><br>
        <button type="submit">Registrar Usuario</button>
    </form>

    <!-- Formulario para registrar un préstamo -->
    <h2>Registrar Préstamo de Libro</h2>
    <form method="POST" action="index.php">
        <input type="hidden" name="action" value="prestamo_libro">
        <label for="usuario_id">ID Usuario:</label>
        <input type="number" name="usuario_id" required><br>
        <label for="libro_id">ID Libro:</label>
        <input type="number" name="libro_id" required><br>
        <button type="submit">Registrar Préstamo</button>
    </form>

    <!-- Formulario para registrar la devolución de un libro -->
    <h2>Registrar Devolución de Libro</h2>
    <form method="POST" action="index.php">
        <input type="hidden" name="action" value="devolucion_libro">
        <label for="prestamo_id">ID Préstamo:</label>
        <input type="number" name="prestamo_id" required><br>
        <label for="libro_id">ID Libro:</label>
        <input type="number" name="libro_id" required><br>
        <button type="submit">Registrar Devolución</button>
    </form>

    <!-- Mostrar todos los libros -->
    <h2>Listar Todos los Libros</h2>
    <?php listarLibros(); ?>

    <!-- Mostrar todos los usuarios -->
    <h2>Listar Todos los Usuarios</h2>
    <?php listarUsuarios(); ?>

    <!-- Mostrar todos los préstamos activos -->
    <h2>Listar Todos los Préstamos Activos</h2>
    <?php listarPrestamos(); ?>
</body>
</html>
