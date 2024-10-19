<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "biblioteca";

// Conexión a la base de datos MySQLi
$conn = new mysqli($host, $user, $password, $database);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
