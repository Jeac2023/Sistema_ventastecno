<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../librerias_css/jquery-ui.min.css">
    <script src="../librerias_js/jquery-3.7.0.min.js"></script>
    <script src="../librerias_js/jquery-ui.min.js"></script>
    <script src="ventas.js"></script>
</head>
<body>
    <header>
        <h1>Ventas</h1>
    </header>
    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="#">Ventas</a></li>
            <li><a href="../Inventario/inventario.php">Inventario</a></li>
            <li><a href="../Usuarios/index.php">Usuarios</a></li>
            <li><a href="#">Clientes</a></li>
            <li><a href="../Reportes/reportes.php">Reportes</a></li>
        </ul>
    </nav>
    <main>
        <section>
            <h2>Registrar Venta</h2>
            <form id="formulario-venta" action="registrar_venta.php" method="POST">
                <label for="cliente">Cliente:</label>
                <input type="text" id="cliente" name="cliente" required>

                <label for="buscar-producto">Producto:</label>
                <input type="text" id="buscar-producto" name="buscar-producto" placeholder="Ingrese el nombre del producto">

                <label for="codigo-producto">Código del Producto:</label>
                <input type="text" id="codigo-producto" name="codigo-producto" readonly>

                <label for="cantidad">Cantidad:</label>
                <input type="number" id="cantidad" name="cantidad" required>

                <input type="submit" id="agregar-carrito" value="Agregar al Carrito">
                <input type="button" value="Cancelar" onclick="window.location.href='ventas.html'" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 4px;">
            </form>
        </section>
        <section>
            <h2>Carrito de Compras</h2>
            <table id="tabla-carrito">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Código</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se mostrarán los productos agregados al carrito -->
                </tbody>
            </table>
        </section>
        <section>
            <h2>Detalle de Venta</h2>
            <table id="tabla-venta">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Código</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se mostrarán los productos agregados al carrito para registrar la venta -->
                </tbody>
            </table>
            <form id="formulario-registro-venta" action="registrar_venta.php" method="POST">
                <input type="hidden" name="cliente" id="cliente-venta" value="">
                <input type="submit" value="Registrar Venta">
            </form>
        </section>
        <section>
            <h2>Imagen del Producto</h2>
            <img src="" id="imagen-producto" alt="Imagen del producto" style="max-width: 500px;">
        </section>
    </main>
</body>
</html>
