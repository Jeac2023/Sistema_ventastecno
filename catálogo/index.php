<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="modal.css">
</head>
<body>
    <h1>Catálogo de Productos</h1>
    
    <div class="catalogo">
        <?php
        // Conexión a la base de datos
        require_once '../conexion_db.php';
        // Consulta SQL para obtener el inventario
        $query = "SELECT * FROM inventario";
        $resultado = mysqli_query($conexion, $query);

        if (mysqli_num_rows($resultado) > 0) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo '<div class="producto">';
                echo '<h3>' . $fila['producto'] . '</h3>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($fila['imagen']) . '" alt="' . $fila['producto'] . '">';
                echo '<p class="precio">S/ ' . number_format($fila['precio'], 2, '.', ',') . '</p>';
                echo '<p class="cantidad"><strong></strong> ' . $fila['stock'] . ' Disponibles</p>';
                echo '<button class="comprar" data-nombre="' . $fila['producto'] . '" data-codigo="' . $fila['codigo'] . '" data-precio="' . $fila['precio'] . '" data-stock="' . $fila['stock'] . '" data-imagen="' . base64_encode($fila['imagen']) . '">Comprar</button>';
                echo '</div>';
            }
        } else {
            echo "<p>No se encontraron productos en el inventario</p>";
        }

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </div>

    <!-- Ventana modal para detalles del producto -->
    <div class="modal" id="modal">
        <div class="modal-contenido">
            <span class="cerrar-modal" id="cerrar-modal">&times;</span>
            <h2>Detalles del Producto</h2>
            <img src="" alt="Imagen del Producto" id="modal-imagen">
            <p><strong>Producto:</strong> <span id="modal-producto"></span></p>
            <p><strong>Código:</strong> <span id="modal-codigo"></span></p>
            <p><strong>Precio:</strong> <span id="modal-precio"></span></p>
            <p><strong>Stock:</strong> <span id="modal-stock"></span></p>
            <button class="comprar-modal" id="comprar-modal">Comprar</button>
        </div>
    </div>

    <script src="modal.js"></script>
</body>
</html>
