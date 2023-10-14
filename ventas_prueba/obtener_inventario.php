<?php
// Conexión a la base de datos
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener el inventario
$query = "SELECT * FROM Inventario";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) > 0) {
    // Generar la tabla con los datos del inventario
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $fila['producto'] . "</td>";
        echo "<td>" . $fila['codigo'] . "</td>";
        echo "<td>S/ " . number_format($fila['precio'], 2, '.', ',') . "</td>"; // Mostrar precio en soles
        echo "<td>" . $fila['stock'] . "</td>";
        echo '<td><img src="data:image/jpeg;base64,' . base64_encode($fila['imagen']) . '" height="100"></td>';
        echo '<td><button class="editar-btn" data-id="' . $fila['id'] . '">Añadir</button></td>';
        echo '<td><button class="borrar-btn" data-id="' . $fila['id'] . '">Quitar</button></td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No se encontraron productos en el inventario</td></tr>";
}

// Cerrar la conexión
mysqli_close($conexion);
?>



