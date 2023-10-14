<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Obtener el ID del producto a editar
    $idProducto = $_GET['id'];

    // Conexión a la base de datos
    require_once '../conexion_db.php';
    // Obtener los datos del producto
    $query = "SELECT * FROM Inventario WHERE id = $idProducto";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) === 1) {
        // Obtener los datos del producto
        $producto = mysqli_fetch_assoc($resultado);

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
        <!-- HTML para editar el producto -->
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Editar Producto</title>
            <link rel="stylesheet" href="../styles.css">
            <script src="mostrar_inventario.js"></script>
            <link rel="stylesheet" href="../sweetalert2.min.css">
            <script src="../sweetalert2.min.js"></script>
        </head>
        <body>
            <header>
                <h1>Editar Producto</h1>
            </header>

            <main>
                <form action="guardar_cambios.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                    <label for="producto">Producto:</label>
                    <input type="text" id="producto" name="producto" value="<?php echo $producto['producto']; ?>" required>
                    
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" value="<?php echo $producto['codigo']; ?>" required>
                    
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>

                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                    <label for=""></label>
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" value="<?php echo $producto['stock']; ?>" required>
                    <input type="submit" value="Guardar Cambios" class="guardar-cambios">
                    <input type="button" value="Cancelar" onclick="window.location.href='inventario.php'" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px;">

                </form>               
            </main>
            <footer>
                <p>Derechos de Autor &copy; 2023 - Librería Evelyn</p>
            </footer>
            <script>
                function confirmarGuardarCambios() {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Se guardarán los cambios realizados',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.querySelector('form').submit();
                        }
                    });
                }

                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelector('.guardar-cambios').addEventListener('click', (event) => {
                        event.preventDefault();
                        confirmarGuardarCambios();
                    });

                    const urlParams = new URLSearchParams(window.location.search);
                    const cambiosExitosos = urlParams.get('cambiosExitosos');
                    if (cambiosExitosos) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cambios guardados',
                            text: 'Se hicieron los cambios exitosamente',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function(){window.location.href="inventario.php";}, 1500);
                    }
                });
            </script>
        </body>
        </html>
        <?php
    } else {
        echo "El producto no existe";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idProducto = $_POST['id'];
    $nuevoProducto = $_POST['producto'];
    $nuevoCodigo = $_POST['codigo'];
    $nuevoPrecio = $_POST['precio'];
    $nuevaImagen = $_FILES['imagen']['tmp_name'];
    $nuevoStock = $_POST['stock'];

    // Conexión a la base de datos
    $conexion = mysqli_connect('localhost:3307', 'root', '', 'sistema_ventas');

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Actualizar los datos del producto en la base de datos
    $query = "UPDATE Inventario SET producto = '$nuevoProducto', codigo = '$nuevoCodigo', precio = $nuevoPrecio, stock = $nuevoStock";

    // Si se seleccionó una nueva imagen, guardarla en la base de datos
    if (!empty($nuevaImagen)) {
        $imagen = file_get_contents($nuevaImagen);
        $imagen = mysqli_real_escape_string($conexion, $imagen);
        $query .= ", imagen = '$imagen'";
    }

    $query .= " WHERE id = $idProducto";

    $resultado = mysqli_query($conexion, $query);

    // Verificar si se actualizó correctamente
    if ($resultado) {
        echo "Los cambios se guardaron correctamente";
    } else {
        echo "Error al guardar los cambios: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "ID de producto no especificado";
}
?>