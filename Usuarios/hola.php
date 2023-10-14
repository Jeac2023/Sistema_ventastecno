<?php
function encriptarPassword($password)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $hashedPassword;
}
$conn = mysqli_connect('localhost:3307', 'root', '', 'sistema_tecnophone');
// Verificar si hay errores en la conexión
if (mysqli_connect_errno()) {
    echo "Error de conexión a la base de datos: " . mysqli_connect_error();
    exit;
}

// Obtener el nombre de usuario a eliminar desde la URL
$nombreUsuario = $_GET['nombre'];

// Verificar si se envió la contraseña del "dueno" en el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contrasenaDueno = $_POST['contrasena_dueno'];
     // Consulta SQL para obtener los datos del usuario
     $query = "SELECT contrasena,rol FROM usuarios WHERE rol = 'Dueño'";
     $stmt = mysqli_prepare($conn, $query);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_bind_result($stmt, $hashedPassword, $rol);
     mysqli_stmt_fetch($stmt);
     mysqli_stmt_free_result($stmt);
     if (password_verify($contrasenaDueno, $hashedPassword)) {
         // Inicio de sesión exitoso, almacenar el mensaje de bienvenida en una variable
         $query = "DELETE FROM usuarios WHERE nombre_usuario = '$nombreUsuario'";
         $resultado = mysqli_query($conn, $query);
        if ($resultado) {
            header("Location: index.php?formulario=true");
            exit();
        } else {
            echo "Error al eliminar el usuario: " . mysqli_error($conn);
        }
    } else {
        echo "Contraseña incorrecta del dueño.";
    }

    // Cerrar la conexión
    mysqli_close($conn);
    exit;
}
?>