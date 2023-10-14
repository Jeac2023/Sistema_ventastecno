<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carga Masiva de Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <h1>Carga Masiva de Productos</h1>
    <form action="procesar_carga.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="archivo_excel" accept=".csv">
        <i class="fas fa-upload"></i>
        <input type="submit" value="Cargar Datos">
    </form>
    <form method="post" action="reiniciar_tabla.php">
        <input type="submit" name="reiniciar" value="Reiniciar Tabla">
    </form>
</body>
</html>

<?php
require_once '../conexion_db.php';

// Consulta SQL para obtener los datos de la tabla 'productos'
$query = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $query);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tabla de Productos</title>
</head>
<body>
    <h1>Tabla de Productos</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Código</th>
            <th>Precio</th>
            <th>Stock</th>
        </tr>
        <?php
        // Iterar a través de los registros y mostrarlos en la tabla
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $fila['id'] . "</td>";
            echo "<td>" . $fila['producto'] . "</td>";
            echo "<td>" . $fila['codigo'] . "</td>";
            echo "<td>" . $fila['precio'] . "</td>";
            echo "<td>" . $fila['stock'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($conexion);
?>
