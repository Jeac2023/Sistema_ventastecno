<?php
session_start();

// Si no se ha iniciado sesión, redirige a la página de inicio de sesión (login.php)
if (!isset($_SESSION['mensaje_bienvenida'])) {
    header('Location: ../Login/index.html');
    exit;
}

// Función para destruir la sesión y redirigir al inicio de sesión
function cerrarSesion()
{
    session_destroy();
    header('Location: ../Login/index.html');
    exit;
}

if (isset($_POST['cerrar_sesion'])) {
    cerrarSesion();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../sweetalert2.min.css">
    <script src="../sweetalert2.min.js"></script>
    <script src="../librerias_js/jquery-3.7.0.min.js"></script>
    <script src="mostrar_inventario.js"></script>
    <script src="buscar_producto.js"></script>
</head>
<body>
    <header>
        <h1>Inventario</h1>
    </header>

    <div class="contenido">
        <div class="sidebar">
            <div class="Usuario">
                <a href="#"><?php echo $_SESSION['Usuario']; ?></a>
                <form method="POST">
                    <button type="submit" class="cerrar-sesion" name="cerrar_sesion">Cerrar Sesión</button>
                </form>
            </div>
            <a href="../index.php"><i class="fa fa-home"></i> Inicio</a>
            <a class="active" href="#"><i class="fa fa-cube"></i> Inventario</a>
            <a href="../Usuarios/index.php"><i class="fa fa-users"></i> Usuarios</a>
            <a href="#"><i class="fa fa-users"></i> Clientes</a>
            <a href="../Reportes/reportes.php"><i class="fa fa-chart-bar"></i> Reportes</a>
        </div>
        <div class="inventario-form">
            <h2>Registrar Producto</h2>
            <form action="registrar_producto.php" method="POST" enctype="multipart/form-data">
                <label for="producto">Producto:</label>
                <input type="text" id="producto" name="producto" required>

                <label for="codigo">Código:</label>
                <input type="text" id="codigo" name="codigo" required>

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>
                
                <input type="submit" value="Añadir Producto">
                <input type="button" value="Cancelar" onclick="window.location.href='inventario.php'" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px;">
            </form>
        </div>
        <div class="inventario">
            <input type="text" id="busqueda" placeholder="Buscar por nombre o código">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Código</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-inventario">
                    <!-- Los datos de la tabla se generarán dinámicamente con JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
    <h1 id="mensaje-no-resultados" style="display: none;">No se encontraron resultados</h1>

    <footer>
        <p>Derechos de Autor &copy; 2023 - Librería Evelyn</p>
    </footer>
    <script>
        const editarBotones = document.querySelectorAll('.editar-modal');
        editarBotones.forEach((boton) => {
            boton.addEventListener('click', function() {
                const idProducto = this.getAttribute('data-id');
                mostrarModalEdicion(idProducto);
            });
        });

        function mostrarModalEdicion(idProducto) {
            // Hacer una solicitud AJAX para obtener los datos del producto desde el servidor
            $.ajax({
                url: 'obtener_producto.php',
                method: 'GET',
                data: { id: idProducto },
                success: function(response) {
                    // Si la solicitud es exitosa, actualizar los campos del formulario con los datos recibidos
                    $('#producto').val(response.producto);
                    $('#codigo').val(response.codigo);
                    $('#precio').val(response.precio);
                    $('#stock').val(response.stock);

                    // Mostrar la ventana modal
                    $('#modal').show();
                },
                error: function() {
                    // Si hay un error en la solicitud, mostrar un mensaje de error o realizar alguna acción adecuada
                }
            });
        }
    </script>
    <script src="../cerrar_sesion.js"></script>
</body>
</html>
