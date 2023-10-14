<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');

// Obtener el término de búsqueda desde la solicitud AJAX
$term = $_GET['term'];

// Consulta SQL para buscar productos que coincidan con el término de búsqueda
$query = "SELECT producto FROM Inventario WHERE producto LIKE '%$term%'";
$result = mysqli_query($conexion, $query);

// Crear un array para almacenar los resultados
$productos = array();

// Recorrer los resultados y agregarlos al array
while ($row = mysqli_fetch_assoc($result)) {
    $productos[] = $row['producto'];
}

// Enviar los resultados como JSON
echo json_encode($productos);
?>
