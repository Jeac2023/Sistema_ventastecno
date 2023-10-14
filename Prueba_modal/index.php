<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../sweetalert2.min.css">
    <script src="../sweetalert2.min.js"></script>
    <script src="buscar.js"></script>
</head>
<body class="tema-claro">
    <h1 class = "claro">Catálogo de Productos Tecnophone</h1>
    <!-- Botón para abrir la ventana modal -->
    <button class="fas fa-plus" id="Agregar"></button>
    <button class="fas fa-upload"id="Cargar"></button>
    <button class="Carro"id="car"><i class="fas fa-shopping-cart"></i></button>
    <span class = "Contador" id = "Contador"></span>
    <button id="cambio-tema" class="cambio-tema"><i class="fas fa-lightbulb"></i></button>
    <button id="foco" class="foco"><i class="fas fa-lightbulb"></i></button>
    <?php
    // Conexión a la base de datos
    require_once '../conexion_db.php';
    // Consulta SQL para obtener el inventario
    $query = "SELECT * FROM inventario";
    $resultado = mysqli_query($conexion, $query);
    echo '</div>';
            echo '<div class="buscador">';
            echo '<input type="text" id="input-busqueda" placeholder="Buscar por Nombre o Código">';
            echo '<span class="limpiar" id="limpiar-busqueda">&times;</span><br>';
            echo '<p id="mensaje-no-resultados">Upss!!! ... No se encontraron Resultados</p>';
    echo '</div>';
    if (mysqli_num_rows($resultado) > 0) {
        // Mostrar los productos como un catálogo
        echo '<div class="catalogo">';
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo '<div class="producto tema-claro">';
            echo '<h3>' . $fila['producto'] . '</h3>';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($fila['imagen']) . '" alt="' . $fila['producto'] . '">';
            echo '<p class="precio tema-claro">S/ ' . number_format($fila['precio'], 2, '.', ',') . '</p>';
            echo '<p class="cantidad"><strong></strong> ' . $fila['stock'] . ' Disponibles</p>';
            //echo '<button class="editar" data-id="' . $fila['id'] . '">Editar</button>';
            // Agregar los datos como atributos de datos en el botón de editar
            echo '<button class="editar" data-id="' . $fila['id'] . '" data-producto="' . $fila['producto'] . '" data-codigo="' . $fila['codigo'] . '" data-precio="' . $fila['precio'] . '" data-stock="' . $fila['stock'] . '" data-imagen="' . base64_encode($fila['imagen']) . '"><i class="fas fa-pencil-alt"></i></button>';
            echo '<button class="eliminar" data-id="' . $fila['id'] . '" data-producto="' . $fila['producto'] . '"> <i class="fas fa-trash"></i></button>';
            echo '<button class="vender" data-producto="' . $fila['producto'] . '" data-precio="' . $fila['precio'] . '" data-stock="' . $fila['stock'] . '" data-imagen="' . base64_encode($fila['imagen']) . '"> <i class="fas fa-shopping-cart"></i></button>';
            echo '</div>';
            // Agregar un contenedor para la imagen clonada (puedes ocultarlo inicialmente)
        }
        echo '</div>';
    } else {
        echo "<p>No se encontraron productos en el inventario</p>";
    }

    // Cerrar la conexión
    mysqli_close($conexion);
    ?>
    <!-- Ventana modal para agregar producto -->
    <div id="Modal-agregar" class="modal">
        <div class="modal-content">
            <span class="cerrar" id="cerrarModal">&times;</span>
            <h2 class="Titulo">Agregar Producto</h2>
            <form id="formulario" enctype="multipart/form-data" action="agregar_producto.php" method="POST">
                <label for="producto">Producto:</label required><br>
                <input type="text" id="producto" name="producto" required><br>
                
                <label for="codigo">Código:</label required><br>
                <input type="text" id="codigo" name="codigo" required><br>
                
                <label for="precio">Precio:</label required><br>
                <input type="number" id="precio" name="precio" step="0.01" required><br>
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required><br>
                
                <label for="stock">Stock:</label required><br>
                <input type="number" id="stock" name="stock" required><br>

                <button type="submit" class="fas fa-check"></button>
            </form>
        </div>
    </div>
    <!-- Ventana modal para editar producto -->
    <div id="Modal-editar" class="modal">
        <div class="modal-content">
            <span class="cerrar-modal" id="cerrar-modal-edicion">&times;</span>
            <h2 class="Titulo" >Editar Producto</h2>
            <form id="formulario-edicion" enctype="multipart/form-data" action="Editar_Producto.php" method="POST">
                <div class="formulario-contenedor">
                    <div class="formulario-izquierda">
                        <input type="hidden" id="producto-id-e" name="producto-id-e" value="">
                        <label for="nombre-e">Nombre: </label required><br>
                        <input type="text" id="nombre-e" name="nombre-e" required><br>
                        
                        <label for="codigo">Código:</label required><br>
                        <input type="text" id="codigo-e" name="codigo-e" required><br>

                        <label for="precio">Precio:</label required><br>
                        <input type="text" id="precio-e" name="precio-e" required><br>
                        <label for="imagen">Imagen:</label required><br>
                        <input type="file" id="imagen-e" name="imagen-e" accept="image/*"><br>
                        
                        <label for="stock">Stock:</label required><br>
                        <input type="number" id="stock-e" name="stock" required><br>   
                    </div>
                    <div class="formulario-derecha">
                        <!-- Elemento para mostrar la imagen -->
                        <img id="imagen-preview" src="" alt="Imagen del producto">
                    </div>
                </div>
                <button type="button" id="boton-guardar-cambios" class="Guardar-Cambios"><i class="fas fa-sync-alt"></i></button>
            </form>
        </div>
    </div>
    <div id="Modal-cargar" class="modal">
        <div class="cargar-contenido">
            <span class="cerrar-carga" id="cerrar-carga">&times;</span>
            <h2 class="Titulo">Carga Masiva</h2>
            <form action="procesar_carga.php" method="POST" enctype="multipart/form-data">
                <input class = "archivo" type="file" name="archivo_excel" accept=".csv" required><br>
                <input type="checkbox" id="actualizar" name="actualizar">
                <label for="actualizar">Actualizar Registros</label> <br>
                <button class = "Cargar" type="submit" value="Cargar Datos"><i class="fas fa-upload"></i>
            </form>
        </div>
    </div>
    <div id="Modal-vender" class="modal1">
        <div class="modal-content1">
            <span class="cerrar-carro" id="cerrar-vender">&times;</span>
            <h3>Carrito de Compra</h3>
            <button class="eliminartodo"><i class="fas fa-trash-alt"></i></button>
            <div id="lista-productos">
            <!-- Los productos seleccionados se agregarán aquí -->
            </div>
            <div>
                <p id="cuenta"></p>
            </div>
        </div>
    </div>
    <div id="imagenClonadaContainer" style="position: fixed;"></div>
    <script src="script.js"></script>
    <script src="alertas.js"></script>
    <script src="carritoCompra.js"></script>
    <script src="carritoanimation.js"></script>
</body>
</html>
