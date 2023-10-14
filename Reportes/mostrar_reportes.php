<?php
// Conexión a la base de datos
require_once '../conexion_db.php';
// Consulta SQL para obtener los productos del inventario
$query = "SELECT * FROM Inventario";
$resultado = $conexion->query($query);

// Array para almacenar los datos del inventario
$inventario = array();

// Comprobar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    // Recorrer los resultados y almacenarlos en el array
    while ($fila = $resultado->fetch_assoc()) {
        // Obtener los datos de la imagen como cadena de bytes
        $imagen = base64_encode($fila['imagen']);

        // Agregar los datos al array
        $inventario[] = array(
            'id' => $fila['id'],
            'producto' => $fila['producto'],
            'codigo' => $fila['codigo'],
            'precio' => "S/ " . number_format($fila['precio'], 2, '.', ','),
            'stock' => $fila['stock'],
            'imagen' => $imagen
        );
    }
}

// Cerrar la conexión
$conexion->close();

// Enviar la respuesta como JSON
echo json_encode($inventario);
?>
