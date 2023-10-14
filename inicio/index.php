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
    <title>Sistema de Ventas e Inventario</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="sweetalert2.min.js"></script>
</head>
<body>
    <header>
        <h1>Sistema de Ventas e Inventario</h1>
        <section>
            <!-- Contenido de la página index.html -->
            <p class="mensaje-inicio"><?php echo $_SESSION['mensaje_bienvenida']; ?></p> 
        </section>
        <section class="cerrar">
            <button type="button" class="cerrar-sesion">Cerrar Sesión</button>
        </section>  
    </header>
    <nav>
        <ul>
            <li><a href="#">Inicio</a></li>
            <li><a href="Ventas/ventas.php">Ventas</a></li>
            <li><a href="Inventario/inventario.php">Inventario</a></li>
            <li><a href="#">Clientes</a></li>
            <li><a href="Reportes/reportes.php">Reportes</a></li>
        </ul>
    </nav>

    <main>
        
    </main>

    <footer>
        <p>Derechos de Autor &copy; 2023 - Tecnophone</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cerrarSesionBtn = document.querySelector('.cerrar-sesion');
            cerrarSesionBtn.addEventListener('click', () => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción cerrará la sesión actual',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, cerrar sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '';
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'cerrar_sesion';
                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
