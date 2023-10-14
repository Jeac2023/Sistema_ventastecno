<?php
// Obtener los datos de la venta
$cliente = $_POST['cliente'];
$producto = $_POST['buscar-producto'];
$codigo = $_POST['codigo-producto'];
$cantidad = $_POST['cantidad'];
$fecha = date('Y-m-d'); // Fecha actual

// Iniciar o reanudar la sesión
session_start();

// Verificar si el carrito de compras existe en la sesión
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Verificar la disponibilidad del producto en el inventario
$conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');
$query = "SELECT stock FROM Inventario WHERE producto = '$producto' AND codigo = '$codigo'";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) === 1) {
    $fila = mysqli_fetch_assoc($resultado);
    $stockDisponible = $fila['stock'];

    if ($stockDisponible >= $cantidad) {
        // Verificar si el producto ya está en el carrito
        $productoEnCarrito = false;
        foreach ($_SESSION['carrito'] as $item) {
            if ($item['producto'] == $producto && $item['codigo'] == $codigo) {
                $productoEnCarrito = true;
                break;
            }
        }

        if (!$productoEnCarrito) {
            // Agregar el producto al carrito
            $itemVenta = array(
                'producto' => $producto,
                'codigo' => $codigo,
                'cantidad' => $cantidad
            );
            $_SESSION['carrito'][] = $itemVenta;
        } else {
            echo "El producto ya se encuentra en el carrito";
        }
    } else {
        echo "La cantidad solicitada excede el stock disponible";
    }
} else {
    echo "El producto no se encuentra en el inventario";
}

// Cerrar la conexión
mysqli_close($conexion);

// Redireccionar a ventas.html
header("Location: ventas.html");
exit();
?>

