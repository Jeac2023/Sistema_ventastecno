<?php
// Conexión a la base de datos
require_once '../conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $idProducto = $_GET['id'];
    
    // Obtener los datos del producto
    $query = "SELECT * FROM Inventario WHERE id = $idProducto";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) === 1) {
        $producto = mysqli_fetch_assoc($resultado);
        // Devolver los datos del producto como respuesta JSON
        echo json_encode($producto);
    } else {
        // Si no se encuentra el producto, devolver un mensaje de error o realizar alguna acción adecuada
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
