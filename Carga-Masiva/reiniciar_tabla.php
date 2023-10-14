<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reiniciar'])) {
    // Conexión a la base de datos (ajusta los detalles de la conexión)
    require_once '../conexion_db.php';

    if ($conexion->connect_error) {
        die("Error en la conexión a la base de datos: " . $conexion->connect_error);
    }

    // Vaciar la tabla
    $query_vaciar = "TRUNCATE TABLE productos";
    if (mysqli_query($conexion, $query_vaciar)) {
        // Reiniciar el contador de ID
        $query_reiniciar = "ALTER TABLE productos AUTO_INCREMENT = 1";
        if (mysqli_query($conexion, $query_reiniciar)) {
            echo "La tabla ha sido reiniciada y vaciada.";
        } else {
            echo "Error al reiniciar el contador de ID: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al vaciar la tabla: " . mysqli_error($conexion);
    }
    header('Location: index.php');
    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
