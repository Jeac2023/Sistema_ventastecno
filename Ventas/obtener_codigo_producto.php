<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');

// Obtener el nombre del producto desde la solicitud AJAX
$producto = $_POST['producto'];

// Consulta SQL para obtener el código y la imagen del producto
$query = "SELECT codigo, imagen FROM Inventario WHERE producto = '$producto'";
$result = mysqli_query($conexion, $query);

// Crear un array para almacenar el resultado
$response = array();

// Verificar si se encontró el producto
if ($row = mysqli_fetch_assoc($result)) {
    $response['codigo'] = $row['codigo'];

    // Obtener los datos de la imagen como cadena de bytes
    $imagen = base64_encode($row['imagen']);
    $response['imagen'] = $imagen;
} else {
    $response['codigo'] = '';
    $response['imagen'] = '';
}

// Enviar el resultado como JSON
echo json_encode($response);
?>

