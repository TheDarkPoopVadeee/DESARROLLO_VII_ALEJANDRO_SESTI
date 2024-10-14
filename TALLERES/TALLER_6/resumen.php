<?php
if (file_exists('registros.json')) {
    $registros = json_decode(file_get_contents('registros.json'), true);
    if (!empty($registros)) {
        echo "<h2>Resumen de Registros Procesados:</h2>";
        echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse;'>";
        echo "<tr><th>Nombre</th><th>Email</th><th>Fecha de Nacimiento</th><th>Edad</th><th>Foto de Perfil</th></tr>";
        
        foreach ($registros as $registro) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($registro['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($registro['email']) . "</td>";
            echo "<td>" . htmlspecialchars($registro['fecha_nacimiento']) . "</td>";
            echo "<td>" . htmlspecialchars($registro['edad']) . "</td>";
            echo "<td><img src='" . htmlspecialchars($registro['foto_perfil']) . "' width='50' alt='Foto de Perfil'></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No hay registros disponibles.</p>";
    }
} else {
    echo "<p>No se ha creado el archivo de registros.</p>";
}
?>