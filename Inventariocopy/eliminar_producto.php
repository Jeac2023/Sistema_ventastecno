<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Obtener el ID del producto a eliminar
    $idProducto = $_POST['id'];

    // Conexión a la base de datos
    require_once '../conexion_db.php';
    // Eliminar el producto de la base de datos
    $query = "DELETE FROM Inventario WHERE id = $idProducto";
    mysqli_query($conexion, $query);

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "ID de producto no especificado";
}
?>
