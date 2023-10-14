<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener los productos del inventario
$query = "SELECT * FROM Inventario";
$resultado = $conexion->query($query);

// Comprobar si se obtuvieron resultados
if ($resultado->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Producto</th><th>Código</th><th>Precio</th><th>Stock</th></tr>";
    
    // Recorrer los resultados y mostrarlos en la tabla
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $fila['id'] . "</td>";
        echo "<td>" . $fila['producto'] . "</td>";
        echo "<td>" . $fila['codigo'] . "</td>";
        echo "<td>" . $fila['precio'] . "</td>";
        echo "<td>" . $fila['stock'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "No se encontraron productos en el inventario.";
}

// Cerrar la conexión
$conexion->close();
?>
