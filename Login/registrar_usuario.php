<?php
require_once 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    // Consulta SQL para insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $username, $hashedPassword, $rol);

    if (mysqli_stmt_execute($stmt)) {
        // Registro exitoso, redirigir a la página de inicio de sesión
        $mensajeRegistro = "¡Registro, $username!";
        session_start();
        $_SESSION['mensaje_bienvenida'] = $mensajeRegistro;
    } else {
        // Error en el registro, mostrar mensaje de error
        $error = "Error al registrar el usuario";
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="sweetalert2.min.js"></script>
</head>
<body>
    <div class="register-page">
        <div class="form">
        <h1>Registro</h1>
            <form class="register-form" method="POST">
                <input type="text" name="username" placeholder="Nombre de Usuario" required/><br>
                <input type="password" name="password" placeholder="Contraseña" required/><br>
                <select class="custom-select" name="rol" required>
                    <option value="Trabajador">Trabajador</option>
                    <option value="Dueño">Dueño</option>
                </select>
                <p></p>
                <button type="submit">Crear</button>
                <?php if (isset($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                    <script>
                    // Muestra el mensaje de error utilizando SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de inicio de sesión',
                        text: '<?php echo $error; ?>',
                        showConfirmButton: false,
                        timer: 2000
                    });
                </script>
                <?php endif; ?>
                <?php if (isset($_SESSION['mensaje_bienvenida'])): ?>
                    <script>
                        // Muestra el mensaje de bienvenida utilizando SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Registro exitoso',
                            text: '<?php echo $_SESSION['mensaje_bienvenida']; ?>',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            // Redirige a index.html después de 2 segundos
                            window.location.href = 'index.html';
                        });
                    </script>
                <?php endif; ?>
                <p class="message">Ya registrado? <a href="index.html">Iniciar Sesión</a></p>
            </form>
        </div>
    </div>
</body>
</html>
