<?php
// Obtener los datos enviados desde el formulario
$id = $_POST['id'];
$producto = $_POST['producto'];
$codigo = $_POST['codigo'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];

// Conexión a la base de datos
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');

// Verificar la conexión
if ($conexion->connect_error) {
   die("Error en la conexión: " . $conexion->connect_error);
}

// Consulta SQL para actualizar los datos del producto
$query = "UPDATE Inventario SET producto='$producto', codigo='$codigo', precio='$precio', stock='$stock' WHERE id=$id";
if (mysqli_query($conexion, $query)) {
   echo "Producto actualizado exitosamente";
} else {
   echo "Error al actualizar el producto: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
