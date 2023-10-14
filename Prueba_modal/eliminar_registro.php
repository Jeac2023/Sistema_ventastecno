<?php
// Conexión a la base de datos (debes configurar tus propias credenciales)
require_once '../conexion_db.php';

// Obtener el valor del parámetro 'id' de la URL
$id = $_GET['id'];
// Realizar la operación de eliminación en la base de datos (asegúrate de tener una tabla adecuada)
$sql = "DELETE FROM inventario WHERE id = $id";
if (mysqli_query($conexion, $sql)) {
    mysqli_close($conexion);
    // Redireccionar a la página de edición con el mensaje de cambios exitosos
    header('Location: index.php?registro_eliminado=true');
    exit();
} else {
    echo "error"; // Error
}


// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
