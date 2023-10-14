<?php
// Obtener los valores enviados por el formulario
$producto = $_POST['producto'];
$codigo = $_POST['codigo'];
$precio = $_POST['precio'];
$imagen = $_FILES['imagen']['tmp_name'];  // Obtener la ruta temporal del archivo de imagen
$stock = $_POST['stock'];

// Conexión a la base de datos
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Leer los datos de la imagen
$imagenData = mysqli_real_escape_string($conexion, file_get_contents($imagen));

// Preparar la consulta SQL con un marcador de posición para la imagen
$query = "INSERT INTO Inventario (producto, codigo, precio, imagen, stock) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "ssdsi", $producto, $codigo, $precio, $imagenData, $stock);

// Ejecutar la consulta
if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
    header("Location: inventario.html");
    exit();
} else {
    echo "Error al registrar el producto en el inventario: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

