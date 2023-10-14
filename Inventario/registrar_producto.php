<?php
// Obtener los valores enviados por el formulario
$producto = $_POST['producto'];
$codigo = $_POST['codigo'];
$precio = $_POST['precio'];
$imagen = $_FILES['imagen']['tmp_name'];  // Obtener la ruta temporal del archivo de imagen
$stock = $_POST['stock'];

// Conexión a la base de datos
require_once '../conexion_db.php';
// Leer los datos de la imagen
$imagenData = file_get_contents($imagen);

// Preparar la consulta SQL con un marcador de posición para la imagen
$query = "INSERT INTO Inventario (producto, codigo, precio, imagen, stock) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ssdsi", $producto, $codigo, $precio, $imagenData, $stock);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir al usuario de vuelta a la página de inventario
    header("Location: inventario.php?registro_exitoso=true");
    exit();
} else {
    echo "Error al registrar el producto en el inventario: " . $conexion->error;
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>


