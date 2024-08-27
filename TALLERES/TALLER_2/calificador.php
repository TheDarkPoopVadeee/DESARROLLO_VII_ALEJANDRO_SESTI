<?php
// Asignar una calificación numérica
$calificacion = 85;  // Cambia este valor para probar diferentes casos

// Usar if-elseif-else para determinar la letra correspondiente
$letra = ($calificacion >= 90) ? "A" :
    (($calificacion >= 80) ? "B" :
    (($calificacion >= 70) ? "C" :
    (($calificacion >= 60) ? "D" : "F")));

// Usar el operador ternario para determinar el estado "Aprobado" o "Reprobado"
$estado = ($letra == "F") ? "Reprobado" : "Aprobado";

// Imprimir el mensaje adicional basado en la letra de la calificación
switch ($letra) {
    case "A":
        $mensaje = "Excelente trabajo";
        break;
    case "B":
        $mensaje = "Buen trabajo";
        break;
    case "C":
        $mensaje = "Trabajo aceptable";
        break;
    case "D":
        $mensaje = "Necesitas mejorar";
        break;
    case "F":
        $mensaje = "Debes esforzarte más";
        break;
    default:
        $mensaje = "Calificación no válida";
        break;
}

// Mostrar el resultado
echo "La calificación numérica es $calificacion y corresponde a la letra: $letra. Estado: $estado. Mensaje: $mensaje.";
?>
