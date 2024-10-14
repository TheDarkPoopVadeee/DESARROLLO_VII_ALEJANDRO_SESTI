<?php
// Establecer opciones para sesiones antes de iniciar la sesión
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Strict');

// Iniciar sesión y establecer opciones de seguridad
session_start([
    'cookie_lifetime' => 86400, 
    'cookie_secure' => true,     
    'cookie_httponly' => true,   
]);
?>
