<!-- inventario.html -->
<?php
session_start();

// Si no se ha iniciado sesión, redirige a la página de inicio de sesión (login.php)
if (!isset($_SESSION['mensaje_bienvenida'])) {
    header('Location: ../Login/index.html');
    exit;
}
// Función para destruir la sesión y redirigir al inicio de sesión
function cerrarSesion() {
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
    
    <!-- <main> -->
    <div class="contenido">
        <div class="sidebar">
            <div class="Usuario">
                <a  href="#"><?php echo $_SESSION['Usuario']; ?></a>
                <button type="submit" class="cerrar-sesion" name="cerrar_sesion">Cerrar Sesión</button>
            </div>
            <a href="../index.php"><i class="fa fa-home"></i> Inicio</a>
            <a class="active" href="#"><i class="fa fa-cube"></i> Inventario</a>
            <a href="../Usuarios/index.php"><i class="fa fa-users"></i> Usuarios</a>
            <a href="#"><i class="fa fa-users"></i> Clientes</a>
            <a href="../Reportes/reportes.php"><i class="fa fa-chart-bar"></i> Reportes</a>
        </div>
        <div class="inventario-form">
            <button id="mostrar-formulario" class="boton-agregar">
                <i class="fas fa-plus-circle"></i> Agregar Producto
            </button>
            <div id="formulario-registro" style="display: none;">
                <h2>Registrar Producto</h2>
                <form action="registrar_producto.php" method="POST" enctype="multipart/form-data"> 
                    <!-- ... tus campos de formulario ... -->
                    <label for="producto">Producto:</label>
                    <input type="text" id="producto" name="producto" required>
                    
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" required>
                    
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" step="0.01" required>

                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                    <label for="espacio"></label>
                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" name="stock" required>
                    <input type="submit" value="Añadir Producto" class="añadir">
                    <input type="button" value="Cancelar" class="Cancelar" onclick="cancelarRegistro()">
                </form>
            </div>
        </div>
        <div class = "inventario">
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
    <!-- </main> -->
    <h1 id="mensaje-no-resultados" style="display: none;">No se encontraron resultados</h1>
    <!-- Ventana modal para editar producto -->
    <div id="modal-edicion" class="modal">
        <div class="modal-content">
            <span class="cerrar-modal" id="cerrar-modal-edicion">&times;</span>
            <h2 class="Titulo" >Editar Producto</h2>
            <form id="formulario-edicion">
                <div class="formulario-contenedor">
                    <div class="formulario-izquierda">
                        <input type="hidden" id="producto-id-e" name="producto-id-e" value="">
                        <label for="nombre">Nombre:</label required><br>
                        <input type="text" id="nombre-e" name="nombre-e" required><br>
                        
                        <label for="codigo">Código:</label required><br>
                        <input type="text" id="codigo-e" name="codigo-e" required><br>

                        <label for="precio">Precio:</label required><br>
                        <input type="text" id="precio-e" name="precio-e" required><br>
                        <label for="imagen">Imagen:</label required><br>
                        <input type="file" id="imagen-e" name="imagen-e" accept="image/*" required><br>
                        
                        <label for="stock">Stock:</label required><br>
                        <input type="number" id="stock-e" name="stock" required><br>   
                    </div>
                    <div class="formulario-derecha">
                        <!-- Elemento para mostrar la imagen -->
                        <img id="imagen-preview" src="" alt="Imagen del producto">
                    </div>
                </div>
                <button type="submit" class="Guardar-Cambios">Guardar Cambios</button>
            </form>
        </div>
    </div>
    <footer>
        <p>Derechos de Autor &copy; 2023 - Tecnophone</p>
    </footer>
    <script>
    // Verificar si hay un parámetro de URL "registro_exitoso" y mostrar el mensaje correspondiente
        const urlParams = new URLSearchParams(window.location.search);
        const registroExitoso = urlParams.get('registro_exitoso');
        if (registroExitoso === 'true') {
            Swal.fire({
                title: 'Registro exitoso',
                text: '',
                icon: 'success'
            }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirigir a la página de eliminación con el parámetro del nombre de usuario
                        window.location.href = `inventario.php`;
                    }
                });
            }
    </script>
    <script src="../cerrar_sesion.js"></script>
    <script src="añadir.js"></script>
</body>
</html>

