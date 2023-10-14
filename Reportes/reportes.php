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
    <title>Reportes</title>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="../librerias_css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../librerias_css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../sweetalert2.min.css">
    <script src="../sweetalert2.min.js"></script>
</head>
<body>
    <header>
        <h1>Reportes</h1>
    </header>
    <div class = "Contenido" >
        <div class="sidebar">
                <div class="Usuario">
                    <a  href="#"><?php echo $_SESSION['Usuario']; ?></a>
                    <button type="submit" class="cerrar-sesion" name="cerrar_sesion">Cerrar Sesión</button>
                </div>
                <a href="../index.php"><i class="fa fa-home"></i> Inicio</a>
                <a href="../Inventario/inventario.php"><i class="fa fa-cube"></i> Inventario</a>
                <a href="../Usuarios/index.php"><i class="fa fa-users"></i> Usuarios</a>
                <a href="#"><i class="fa fa-users"></i> Clientes</a>
                <a class="active" href="#"><i class="fa fa-chart-bar"></i> Reportes</a>
        </div>
        <div class="tabla-reportes">
            <table id="tabla-inventario">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Código</th>
                        <th>Precio</th>
                        <th>Stock</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <script src="../librerias_js/jquery-3.7.0.min.js"></script>
    <script src="../librerias_js/jquery.dataTables.min.js"></script>
    <script src="../librerias_js/dataTables.buttons.min.js"></script>
    <script src="../librerias_js/jszip.min.js"></script>
    <script src="../librerias_js/pdfmake.min.js"></script>
    <script src="../librerias_js/vfs_fonts.js"></script>
    <script src="../librerias_js/buttons.html5.min.js"></script>
    <script src="../librerias_js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabla-inventario').DataTable({
                "ajax": {
                    "url": "mostrar_reportes.php",
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "producto" },
                    { "data": "codigo" },
                    { "data": "precio" },
                    { "data": "stock" }
                ],
                "language": {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "zeroRecords": "No se encontraron registros coincidentes",
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
            }
        },
                dom: 'Bfrtip',
                "buttons": [
                {
                extend: 'excel',
                text: 'Exportar a Excel'
            },
            {
                extend: 'pdf',
                text: 'Exportar a PDF'
            },
            {
                extend: 'print',
                text: 'Imprimir'
            }
                ]
            });
        });
    </script>
    <footer>
        <p>Derechos de Autor &copy; 2023 - Tecnophone</p>
    </footer>
    <script src="../cerrar_sesion.js"></script>
</body>
</html>
