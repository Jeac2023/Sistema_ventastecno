<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idProducto = $_POST['id'];
    $nuevoProducto = $_POST['producto'];
    $nuevoCodigo = $_POST['codigo'];
    $nuevoPrecio = $_POST['precio'];
    $nuevaImagen = $_FILES['imagen']['tmp_name'];
    $nuevoStock = $_POST['stock'];

    // Conexión a la base de datos
    require_once '../conexion_db.php';
    // Actualizar los datos del producto en la base de datos
    $query = "UPDATE Inventario SET producto = '$nuevoProducto', codigo = '$nuevoCodigo', precio = $nuevoPrecio, stock = $nuevoStock";

    // Si se seleccionó una nueva imagen, guardarla en la base de datos
    if (!empty($nuevaImagen)) {
        $imagen = file_get_contents($nuevaImagen);
        $imagen = mysqli_real_escape_string($conexion, $imagen);
        $query .= ", imagen = '$imagen'";
    }

    $query .= " WHERE id = $idProducto";

    $resultado = mysqli_query($conexion, $query);

    // Verificar si se actualizó correctamente
    if ($resultado) {
        // Cerrar la conexión
        mysqli_close($conexion);
        
        // Redireccionar a la página de edición con el mensaje de cambios exitosos
        $url = "editar_producto.php?id=$idProducto&cambiosExitosos=true";
        header("Location: $url");
        exit();
    } else {
        echo "Error al guardar los cambios: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "Solicitud inválida";
}
?>
