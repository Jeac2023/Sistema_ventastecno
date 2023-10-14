<?php
require_once '../conexion_db.php';

if (isset($_POST['nombre']) && isset($_POST['rol'])) {
    $nombreUsuario = $_POST['nombre'];
    $rol = $_POST['rol'];

    // Actualizar los datos del usuario en la base de datos
    $query = "UPDATE usuarios SET rol = '$rol' WHERE nombre_usuario = '$nombreUsuario'";
    mysqli_query($conexion, $query);

    // Redirigir a la página de usuarios con el parámetro "registro_exitoso"
    header('Location: index.php?registro_exitoso=true');
    exit;
} else {
    // Si no se enviaron los datos esperados, redirigir a la página de usuarios
    header('Location: index.php');
    exit;
}
?>
