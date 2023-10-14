<?php
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');
// Verificar la conexión
if (!$conexion) {
  die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Consultar los productos desde la tabla "inventario"
$query = "SELECT producto, codigo, precio FROM inventario";
$resultado = mysqli_query($conexion, $query);

$products = array();

if (mysqli_num_rows($resultado) > 0) {
  // Obtener los datos de cada producto y agregarlos al array de productos
  while ($row = mysqli_fetch_assoc($resultado)) {
    $product = array(
      "producto" => $row["producto"],
      "codigo" => $row["codigo"],
      "precio" => $row["precio"]
    );
    $products[] = $product;
  }
}

// Devolver los productos en formato JSON
header("Content-Type: application/json");
echo json_encode($products);

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
