<?php
// Configuración de la base de datos
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'carrito';

// Crear conexión y seleccionar la base de datos
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Verificar conexión
if ($db->connect_error) {
    die("Error de conexión a la base de datos: " . $db->connect_error);
}
?>
