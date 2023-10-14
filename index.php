<?php
session_start();

// Si no se ha iniciado sesión, redirige a la página de inicio de sesión (login.php)
if (!isset($_SESSION['mensaje_bienvenida'])) {
    header('Location: Login/index.html');
    exit;
}

// Función para destruir la sesión y redirigir al inicio de sesión
function cerrarSesion() {
    session_destroy();
    header('Location: Login/index.html');
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
    <title>Sistema de Ventas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="sweetalert2.min.js"></script>
</head>
<body>
    <header>
        <h1>Sistema de Ventas</h1>
        <section>
            <!-- Contenido de la página index.html -->
            <p class="mensaje-inicio"><?php echo $_SESSION['mensaje_bienvenida']; ?></p> 
        </section>
    </header>
    <div class="sidebar">
        <div class="Usuario">
            <a  href="#"><?php echo $_SESSION['Usuario']; ?></a>
            <button type="submit" class="cerrar-sesion" name="cerrar_sesion">Cerrar Sesión</button>
        </div>
        <a class="active" href="#"><i class="fa fa-home"></i> Inicio</a>
        <a href="Inventario/inventario.php"><i class="fa fa-cube"></i> Inventario</a>
        <a href="Usuarios/index.php"><i class="fa fa-users"></i> Usuarios</a>
        <a href="#"><i class="fa fa-users"></i> Clientes</a>
        <a href="Reportes/reportes.php"><i class="fa fa-chart-bar"></i> Reportes</a>
    </div>
    <main>
    </main>
    <footer>
        <p>Derechos de Autor &copy; 2023 - Tecnophone</p>
    </footer>
    <script src="cerrar_sesion.js"></script>
</body>
</html>
