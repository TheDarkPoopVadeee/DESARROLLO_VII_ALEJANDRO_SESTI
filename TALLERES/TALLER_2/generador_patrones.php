<?php
// 1. Patrón de Triángulo Rectángulo con Asteriscos Usando un Bucle `for`

echo "<h2>Triángulo Rectángulo:</h2>";
$filas = 5;
for ($i = 1; $i <= $filas; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";  // Nueva línea después de cada fila
}

// 2. Secuencia de Números Impares del 1 al 20 Usando un Bucle `while`

echo "<h2>Números Impares del 1 al 20:</h2>";
$numero = 1;
while ($numero <= 20) {
    echo $numero . "<br>";
    $numero += 2;  // Incrementar en 2 para obtener solo números impares
}

// 3. Contador Regresivo Desde 10 Hasta 1 Usando un Bucle `do-while` (Saltando el Número 5)

echo "<h2>Contador Regresivo (Saltando el Número 5):</h2>";
$numero = 10;
do {
    if ($numero != 5) {  // Verificar si el número no es 5
        echo $numero . "<br>";
    }
    $numero--;  // Decrementar el contador
} while ($numero >= 1);
?>