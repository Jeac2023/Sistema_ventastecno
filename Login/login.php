<?php
require_once 'conexion_db.php';

// Función para encriptar la contraseña
function encriptarPassword($password)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $hashedPassword;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para obtener los datos del usuario
    $query = "SELECT contrasena, rol FROM usuarios WHERE nombre_usuario = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashedPassword, $rol);
    mysqli_stmt_fetch($stmt);

    if (password_verify($password, $hashedPassword)) {
        // Inicio de sesión exitoso, almacenar el mensaje de bienvenida en una variable
        $Usuario = "$username";
        $mensajeBienvenida = "¡Bienvenido, $username!";

        // Almacenar el mensaje en una variable de sesión
        session_start();
        $_SESSION['mensaje_bienvenida'] = $mensajeBienvenida;
        $_SESSION['Usuario'] = $Usuario;
    } else {
        // Error de inicio de sesión, mostrar mensaje de error
        $error = "Nombre de usuario o contraseña incorrectos";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="sweetalert2.min.js"></script>
</head>
<body>
    <div class="login-page">
        <div class="form">
            <img src="../Tecnophone.png" alt="tecnophone" width="200px">
            <h1>Inicio de Sesión</h1>
          <form class="login-form" method="POST">
            <input type="text" name="username" placeholder="Nombre de Usuario" required/>
            <input type="password" name="password" placeholder="Contraseña" required/>
            <button type="submit">Ingresar</button>
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
                        title: 'Inicio de sesión exitoso',
                        text: '<?php echo $_SESSION['mensaje_bienvenida']; ?>',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        // Redirige a index.html después de 2 segundos
                        window.location.href = '../index.php';
                    });
                </script>
            <?php endif; ?>
            <p class="message">No estás registrado? <a href="registrar_usuario.php">Crear Cuenta</a></p>
          </form>
        </div>
    </div>
</body>
</html>
