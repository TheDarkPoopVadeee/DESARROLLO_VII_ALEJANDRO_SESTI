<?php
// Nombre del archivo que deseas leer
$nombreArchivo = "ejemplo.txt";

// Verifica si el archivo existe antes de intentar leerlo
if (file_exists($nombreArchivo)) {
    // Lee el contenido del archivo
    $contenidoArchivo = file_get_contents($nombreArchivo);
    echo "Contenido del archivo $nombreArchivo:</br>$contenidoArchivo</br>";
} else {
    // Muestra un mensaje de error si el archivo no existe
    echo "El archivo $nombreArchivo no existe o no se puede abrir.</br>";
}

// Ejercicio: Usa file_get_contents() para leer el contenido de tu propio archivo PHP
$nombrePhp = "array_push.php"; // Asegúrate de que este archivo existe

if (file_exists($nombrePhp)) {
    $contenidoPhp = file_get_contents($nombrePhp);
    echo "</br>Contenido del archivo $nombrePhp:</br>$contenidoPhp</br>";
} else {
    echo "El archivo $nombrePhp no existe o no se puede abrir.</br>";
}

// Bonus: Usa file_get_contents() para obtener el contenido de una página web
$url = "https://www.example.com";
$contenidoWeb = @file_get_contents($url); // El @ suprime los warnings

if ($contenidoWeb === false) {
    echo "</br>Error: No se pudo acceder al contenido de la URL $url.</br>";
} else {
    echo "</br>Contenido de $url:</br>" . substr($contenidoWeb, 0, 500) . "...</br>"; // Mostramos solo los primeros 500 caracteres
}

// Extra: Manejo de errores al usar file_get_contents() para un archivo inexistente
$archivoInexistente = "archivo_que_no_existe.txt";
$contenidoInexistente = @file_get_contents($archivoInexistente); // El @ suprime los warnings

if ($contenidoInexistente === false) {
    echo "</br>Error: No se pudo leer el archivo '$archivoInexistente'.</br>";
} else {
    echo "</br>Contenido del archivo '$archivoInexistente':</br>$contenidoInexistente</br>";
}
?>

      
