<?php
$conn = mysqli_connect('localhost:3307', 'root', '', 'sistema_tecnophone');

// Verificar si hay errores en la conexión
if (mysqli_connect_errno()) {
    echo "Error de conexión a la base de datos: " . mysqli_connect_error();
    exit;
}
?>
