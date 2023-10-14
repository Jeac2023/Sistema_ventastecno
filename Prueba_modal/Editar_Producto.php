<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProducto = $_POST['producto-id-e'];
    $nuevoProducto = $_POST['nombre-e'];
    $nuevoCodigo = $_POST['codigo-e'];
    $nuevoPrecio = $_POST['precio-e'];
    $nuevaImagen = $_FILES['imagen-e']['tmp_name'];
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
        header('Location: index.php?actualizacion_exitosa=true');
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